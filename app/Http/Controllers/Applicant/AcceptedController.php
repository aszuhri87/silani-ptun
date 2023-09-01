<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Libraries\PageLib;
use App\Models\Admin;
use App\Models\Applicant;
use App\Models\DispositionDocument;
use App\Models\DispositionUser;
use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\DocumentCategoryRequirement;
use App\Models\DocumentRequirement;
use App\Models\User;
use DataTables;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use PDF;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class AcceptedController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $notify = DB::table('notifications')->where('notifiable_id', Auth::user()->id)->whereNull('read_at')->get();
        foreach ($notify as $item1) {
            $dat = json_decode($item1->data);
            if ($dat->type == 'done') {
                $notify1 = DB::table('notifications')->where('id', $item1->id);
                $notify1->update(['read_at' => date('Y-m-d H:i:s')]);
            }
        }

        return view('applicant.accepted.index', PageLib::config([]));
    }

    public function dt()
    {
        $appl = Applicant::select('*')->where('user_id', Auth::user()->id)->first();

        $data = DB::table('documents')
            ->select([
                'documents.id',
                'documents.name',
                'documents.status',
                'documents.notes',
                'documents.updated_at as date_create',
                'document_categories.name as document_category',
                'document_categories.unit_id',
                'applicants.name as applicant',
            ])->leftJoin('applicants', 'applicants.id', 'documents.applicant_id')
            ->leftJoin('document_categories', 'document_categories.id', 'documents.document_category_id')
            ->where(function ($query) {
                $query->where('documents.status', '=', 'Diterima')
                    ->orWhere('documents.status', '=', 'Ditolak')
                    ->orWhere('documents.status', '=', 'Belum Bayar')
                    ->orWhere('documents.status', '=', 'Menunggu Konfirmasi Pembayaran');

            })
            ->where('documents.applicant_id', $appl->id)
            ->whereNull('documents.deleted_at')
            ->orderBy('documents.updated_at', 'DESC');

        $admin = Admin::where('user_id', Auth::id())->first();

        $user = User::where('id', Auth::id())->first();
        if ($user->hasRole('admin')) {
            $data->where('unit_id', $admin->unit_id);

            return DataTables::query($data)->addIndexColumn()->make(true);
        } else {
            return DataTables::query($data)->addIndexColumn()->make(true);
        }
    }

    public function store(Request $request)
    {
        try {
            $result = DB::transaction(function () use ($request) {
                $data = DocumentRequirement::create([
                    'requirement_value' => $request->requirement_value,
                    'document_id' => $request->select_docs,
                    'document_category_requirement_id' => $request->select_docs_category_req,
                ]);

                return $data;
            });

            return response([
                'data' => $result,
                'message' => 'Data Tersimpan',
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        $doc_category_req = DocumentCategoryRequirement::select([
            '*',
        ])->whereNull('deleted_at');

        $data = Document::select([
            'documents.id',
            'documents.name',
            'documents.status',
            'documents.notes',
            'documents.updated_at as date_create',
            'document_categories.name as document_category',
            'applicants.name as applicant',
            'document_category_req.requirement_type',
            'document_category_req.requirement',
            'document_category_req.required',
            'document_category_req.description',
        ])
            ->leftJoin('applicants', 'applicants.id', 'documents.applicant_id')
            ->leftJoin('document_categories', 'document_categories.id', 'documents.document_category_id')
            ->leftJoinSub($doc_category_req, 'document_category_req', function ($join) {
                $join->on('document_category_req.document_category_id', 'document_categories.id');
            })
            ->where('documents.id', $id)
            ->whereNull('documents.deleted_at')
            ->first();

        $transfer_img = DocumentRequirement::where('document_id', $id)->where('type', 'Bukti Transfer PNBP')->first();

        $img = null;

        if($transfer_img == null){
            $img = null;
        } else {
            $img = $transfer_img->requirement_value;
        }

        $data->transfer_img = $img;

        return Response::json($data);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Document::find($id);
            $data->update([
                'status' => $request->status_edit ? $request->status_edit : $data->status,
            ]);

            return response([
                'data' => $data,
                'message' => 'Data Terubah',
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $result = Document::find($id);

            DB::transaction(function () use ($result) {
                $result->delete();
            });

            if ($result->trashed()) {
                return response([
                    'message' => 'Successfully deleted!',
                ], 200);
            }
        } catch (Exception $e) {

            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function print($id)
    {
        date_default_timezone_set('Asia/Jakarta');

        $data = DispositionDocument::select('*')->where('document_id', $id)->first();

        $user = DispositionUser::select([
            'disposition_users.role',
            'disposition_users.instruction',
            'users.name',
        ])
            ->leftJoin('users', 'users.id', 'disposition_users.user_id')
            ->where('disposition_users.disposition_document_id', $data->id)
            ->whereNull('disposition_users.deleted_at')
            ->get();

        $data->disposition = $user;

        $pdf = PDF::loadView(
            '/applicant/accepted/print',
            [
                'data' => $data,
            ]
        )->setOptions(['defaultFont' => 'sans-serif'])->setPaper('A4', 'potrait');

        $fileName = 'dokumen_lengkap_' . time() . '.pdf';

        return $pdf->download(public_path($fileName));
    }

    public function upload_transfer(Request $request, $id)
    {
        try {
            $data = null;

            $check = DocumentRequirement::where('document_id', $id)->where('type', '=', 'Bukti Transfer PNBP')->first();

            if($request->hasFile('transfer_image')){
                $file = $request->file('transfer_image');
                $ext = $file->extension();
                if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg') {
                    $name = 'transfer_image' . '_' . date('Y-m-d_s') . '.' .$ext;
                } else {
                    $name = 'transfer_image' . '_' . date('Y-m-d_s') . '.' .'jpg';
                }

                $file->move(public_path() . '/files/', $name);

                $img = $name;

                if ($check){
                    $data = DocumentRequirement::where('document_id', $id)->where('type', '=', 'Bukti Transfer PNBP');
                    $data->update([
                        'requirement_value' => $img,
                        'document_id' => $id,
                        'type' => 'Bukti Transfer PNBP'
                    ]);
                } else {
                    $data = DocumentRequirement::create([
                        'requirement_value' => $img,
                        'document_id' => $id,
                        'type' => 'Bukti Transfer PNBP'
                    ]);
                }

            }

            Document::where('id', $id)->update([
                'status' => "Menunggu Konfirmasi Pembayaran"
            ]);

            return response([
                'data' => $data,
                'message' => 'Data Terubah',
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
