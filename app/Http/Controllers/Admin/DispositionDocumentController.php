<?php

namespace App\Http\Controllers\Admin;

use App\Events\DispositionNotif;
use App\Http\Controllers\Controller;
use App\Models\DispositionDocument;
use App\Models\DispositionUser;
use App\Models\User;
use App\Notifications\NewLetter;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDF;
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

        return view('admin.disposition.index', ['data' => $data]);
    }

    public function dt()
    {
        $data = DB::table('disposition_documents')
        ->select([
            '*',
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
            $file_name = $file->getClientOriginalName();
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
            if ($request->hasFile('uploaded_file')) {
                $file = $request->file('uploaded_file');
                $file_name = $file->getClientOriginalName();
                $file->move(public_path().'/files/', $file_name);
            }

            $data = DispositionDocument::find($id);
            $data->update([
                // 'admin_id' => Auth::user()->id ? $data->id : null,
                'user_id' => $request->role ? $data->user_id : null,
                'index' => $request->index ? $data->index : null,
                'letter_type' => $request->letter_type ? $data->letter_type : null,
                'code' => $request->code ? $data->code : null,
                'date_finish' => $request->date_finish ? $data->date_finish : null,
                'date_number' => $request->date_number ? $data->date_number : null,
                'from' => $request->from ? $data->from : null,
                'resume_content' => $request->resume_content ? $data->resume_content : null,
                'agenda_number' => $request->agenda_number ? $data->agenda_number : null,
                'agenda_date' => $request->agenda_date ? $data->agenda_date : null,
                'forward_to' => $request->forward_to ? $data->forward_to : null,
                'instruction' => $request->instruction ? $data->instruction : null,
                'uploaded_file' => $file_name ? $data->uploaded_document : null,
            ]);

            $user = User::where('title', $request->role)->first();
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
        $data = DispositionDocument::select('*')->where('id', $id)->first();

        $user = DispositionUser::select([
            'disposition_users.role',
            'disposition_users.instruction',
            'users.name',
        ])
        ->leftJoin('users', 'users.id', 'disposition_users.user_id')
        ->whereNull('disposition_users.deleted_at')
        ->get();

        $data->disposition = $user;

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
            throw new Exception($e);

            return response([
                'message' => $e->getMessage(),
            ]);
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
        ->whereNull('disposition_users.deleted_at')
        ->get();

        $data->disposition = $user;

        $pdf = PDF::loadView('/admin/disposition/print',
        [
            'data' => $data,
        ]
        )->setOptions(['defaultFont' => 'sans-serif'])->setPaper('A4', 'potrait');

        $name = date('Y-m-d_s').' '.'.pdf';

        Storage::put('public/pdf/'.$name, $pdf->output());

        return $pdf->stream($name);
    }
}
