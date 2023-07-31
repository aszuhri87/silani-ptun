<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Libraries\PageLib;
use App\Models\Admin;
use App\Models\Applicant;
use App\Models\Document;
use App\Models\DocumentCategoryRequirement;
use App\Models\DocumentRequirement;
use App\Models\User;
use App\Notifications\NewLetter;
use DataTables;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class AcceptedController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $docs_req_category = DocumentCategoryRequirement::select([
            'requirement_types.data_type as data_type',
            'requirement_types.description as title', 'document_category_requirements.*',
        ])
        ->leftJoin('requirement_types', 'requirement_types.requirement_type', 'document_category_requirements.requirement_type')
        ->whereNull(['document_category_requirements.deleted_at', 'requirement_types.deleted_at'])
        ->get();

        $notify = DB::table('notifications')->where('notifiable_id', Auth::user()->id)->whereNull('read_at')->get();
        foreach ($notify as $item1) {
            $dat = json_decode($item1->data);
            if ($dat->type == 'done') {
                $notify1 = DB::table('notifications')->where('id', $item1->id);
                $notify1->update(['read_at' => date('Y-m-d H:i:s')]);
            }
        }

        return view('admin.accepted.index', PageLib::config([]), ['docs_req_category' => $docs_req_category]);
    }

    public function dt()
    {
        $data = DB::table('documents')
        ->select([
            'documents.id',
            'documents.name',
            'documents.status',
            'documents.notes',
            DB::raw("to_char(documents.updated_at , 'dd TMMonth YYYY, HH24:mi' ) as date_create"),
            'document_categories.name as document_category',
            'document_categories.unit_id',
            'applicants.name as applicant',
        ])->leftJoin('applicants', 'applicants.id', 'documents.applicant_id')
        ->leftJoin('document_categories', 'document_categories.id', 'documents.document_category_id')
        ->where(function ($query) {
            $query->where('documents.status', '=', 'Diterima')
            ->orWhere('documents.status', '=', 'Ditolak');
        })
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
            'requirement_types.data_type as data_type',
            'requirement_types.description as title', 'document_category_requirements.*',
        ])
        ->leftJoin('requirement_types', 'requirement_types.requirement_type', 'document_category_requirements.requirement_type')
        ->whereNull([
            'document_category_requirements.deleted_at',
            'requirement_types.deleted_at',
        ]);

        $data = Document::select([
            'documents.id',
            'documents.name',
            'documents.status',
            'documents.notes',
             DB::raw("to_char(documents.created_at , 'dd TMMonth YYYY, HH24:mi' ) as date_create"),
            'document_categories.name as document_category',
            'applicants.name as applicant',
            'document_category_req.requirement_type',
            'document_category_req.requirement',
            'document_category_req.required',
            'document_category_req.description',
            // 'document_requirements.requirement_value',
            'document_category_req.title',
            'document_category_req.data_type',
        ])
        ->with(['doc_req' => function ($query) {
            $query->select([
                'document_requirements.requirement_value',
                'document_requirements.document_id',
                'document_requirements.type',
                'document_category_requirements.requirement_type', ])
            ->leftJoin('document_category_requirements', 'document_category_requirements.id', 'document_requirements.document_category_requirement_id');
        },
        ])
        ->leftJoin('document_requirements', 'document_requirements.document_id', 'documents.id')
        ->leftJoin('applicants', 'applicants.id', 'documents.applicant_id')
        ->leftJoin('document_categories', 'document_categories.id', 'documents.document_category_id')
        ->leftJoinSub($doc_category_req, 'document_category_req', function ($join) {
            $join->on('document_category_req.id', 'document_requirements.document_category_requirement_id');
        })
        ->where('document_requirements.document_id', $id)
        ->whereNull('documents.deleted_at')
        ->first();

        return Response::json($data);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Document::find($id);
            $data->update([
                'status' => $request->status_edit ? $request->status_edit : $data->status,
                'notes' => $request->notes ? $request->notes : $data->notes,
            ]);

            $applicant = Applicant::where('id', $data->applicant_id)->first();
            $user = User::where('id', $applicant->user_id)->first();

            $user->notify(new NewLetter('done', $data->id, $user, 'done'));

            $admin = User::where('category', 'admin')->get();
            foreach ($admin as $a) {
                $a->notify(new NewLetter('done', $data->id, $a, 'done'));
            }

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
}
