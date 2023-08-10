<?php

namespace App\Http\Controllers\Admin;

use App\Events\DispositionNotif;
use App\Http\Controllers\Controller;
use App\Libraries\PageLib;
use App\Models\DispositionDocument;
use App\Models\DispositionUser;
use App\Models\Document;
use App\Models\DocumentRequirement;
use App\Models\User;
use App\Notifications\NewLetter;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDF;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;
use Yajra\DataTables\Facades\DataTables;

class DispositionDocumentController extends Controller
{
    public function index()
    {
        $docs = DB::table('disposition_documents')->select('*')
        ->whereNull('deleted_at')
        ->orderBy('created_at', 'desc')
        ->get();

        $data = [];

        foreach ($docs as $item) {
            $user_disposition = DispositionUser::select([
                'id as disposition_id',
                'user_id',
                'role',
                'note',
                'instruction',
            ])
            ->where('disposition_document_id', $item->id)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();

            $item->user_disposition = $user_disposition;
            $data[] = $item;
        }

        $notify = DB::table('notifications')->where('notifiable_id', Auth::user()->id)->whereNull('read_at')->get();
        foreach ($notify as $item1) {
            $dat = json_decode($item1->data);
            if ($dat->type == 'disposition') {
                $notify1 = DB::table('notifications')->where('id', $item1->id);
                $notify1->update(['read_at' => date('Y-m-d H:i:s')]);
            }
        }

        return view('admin.disposition.index', PageLib::config([]), ['data' => $data]);
    }

    public function dt()
    {
        $data = DB::table('disposition_documents')
        ->select([
            '*',
            DB::raw("CASE WHEN disposition_documents.status IS NULL THEN 'Menunggu' ELSE disposition_documents.status END as status"),
        ])
        ->whereNull('deleted_at')
        ->orderBy('created_at', 'desc');

        return DataTables::query($data)->addIndexColumn()->make(true);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $file_name = null;

        if ($request->uploaded_file) {
            $file = $request->file('uploaded_file');
            $file_name = date('Y-m-d_s').'.pdf';
            $file->move(public_path().'/files/', $file_name);
        }

        $docs = DispositionDocument::create([
            'index' => $request->index,
            'letter_type' => $request->letter_type,
            'code' => $request->code,
            'date_finish' => $request->date_finish,
            'date_number' => $request->date_number,
            'from' => $request->from,
            'resume_content' => $request->resume_content,
            'agenda_number' => $request->agenda_number,
            'agenda_date' => $request->agenda_date,
            'uploaded_document' => $file_name,
        ]);

        $user = User::where('title', $request->role)->first();


        // if ($user->id == Auth::user()->id) {
        // }

        $user_disposition = DispositionUser::create([
                'user_id' => $user->id,
                'disposition_document_id' => $docs->id,
                'role' => $request->role,
                'note' => $request->note,
                'instruction' => $request->instruction,
                'status' => 'Menunggu',
            ]);

        // event(new DispositionNotif('Permintaan Disposisi baru'));
        $user->notify(new NewLetter('disposition', $docs->id, $user, 'disposition'));

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $file_name = null;

        try {
            // dd($request->letter_type);
            if ($request->hasFile('uploaded_file')) {
                $file = $request->file('uploaded_file');
                $file_name = date('Y-m-d_s').'.pdf';
                $file->move(public_path().'/files/', $file_name);
            }

            // dd($request->index);

            $data = DispositionDocument::find($id);
            $data->update([
                // 'user_id' => $request->role,
                'index' => $request->index,
                'letter_type' => $request->letter_type,
                'code' => $request->code,
                'date_finish' => $request->date_finish,
                'date_number' => $request->date_number,
                'from' => $request->from,
                'resume_content' => $request->resume_content,
                'agenda_number' => $request->agenda_number,
                'agenda_date' => $request->agenda_date,
                'forward_to' => $request->forward_to,
                'instruction' => $request->instruction,
                'uploaded_document' => $file_name,
            ]);

            $user = User::where('title', $request->role)->first();

            $user_disposition = DispositionUser::create([
                'user_id' => $user->id,
                'disposition_document_id' => $data->id,
                'role' => $request->role,
            ]);

            $user->notify(new NewLetter('disposition', $id, $user, 'disposition'));

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

    public function show($id)
    {

        $data = DispositionDocument::select(
            'disposition_documents.*',
        )
        ->where('disposition_documents.id', $id)->first();

        $doc_file = DocumentRequirement::select('requirement_value', 'type')
        ->where('document_id', $data->document_id)
        ->whereNull('deleted_at')
        ->get();

        $user = DispositionUser::select([
            'disposition_users.role',
            'disposition_users.instruction',
            'users.name',
        ])
        ->leftJoin('users', 'users.id', 'disposition_users.user_id')
        ->where('disposition_users.disposition_document_id', $id)
        ->whereNull('disposition_users.deleted_at')
        ->get();

        $data->disposition = $user;
        $data->document_file = $doc_file;

        return response()->json([
            'data' => $data,
        ]);
    }

    public function destroy($id)
    {
        try {
            $result = DispositionDocument::find($id);

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

        $data = DispositionDocument::select('*')->where('id', $id)->first();

        $user = DispositionUser::select([
            'disposition_users.role',
            'disposition_users.instruction',
            'users.name',
        ])
        ->leftJoin('users', 'users.id', 'disposition_users.user_id')
        ->where('disposition_users.disposition_document_id', $id)
        ->whereNull('disposition_users.deleted_at')
        ->get();

        $data->disposition = $user;

        $pdf = PDF::loadView('/admin/disposition/print',
        [
            'data' => $data,
        ]
        )->setOptions(['defaultFont' => 'sans-serif'])->setPaper('A4', 'potrait');

        $name = date('Y-m-d_s').' '.'.pdf';

        // Storage::put('public/pdf/'.$name, $pdf->output());

        $pdfVersion = '1.4';
        $newFile = public_path('files/'.$id.'.pdf');
        $currentFile = public_path('files/"'.$data->uploaded_document.'"');

        echo shell_exec("gs -sDEVICE=pdfwrite  -dPDFFitPage -dCompatibilityLevel=1.4 -dEmbedAllFonts=true -dDownsampleColorImages=false -dDownsampleGrayImages=false -dDownsampleMonoImages=false -f -dCompatibilityLevel=$pdfVersion -dNOPAUSE -dBATCH -sOutputFile=$newFile $currentFile");

        ob_end_clean();

        Storage::put('public/pdf/'.$name, $pdf->output());

        $pdfMerge = PDFMerger::init();

        $pdfMerge->addPDF(storage_path('app/public/pdf/'.$name), 'all');
        $pdfMerge->addPDF($newFile, 'all');

        $fileName = 'dokumen_lengkap_'.time().'.pdf';
        $pdfMerge->merge();
        $pdfMerge->save(public_path('files/merged/'.$fileName));

        return $pdfMerge->stream(public_path($fileName));

        // return $pdf->stream($name);
    }
}
