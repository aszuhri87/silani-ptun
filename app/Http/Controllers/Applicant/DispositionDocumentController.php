<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Libraries\PageLib;
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
                'status as status_user',
            ])
            ->where('disposition_document_id', $item->id)
            ->where('user_id', Auth::user()->id)
            ->orWhere('role', Auth::user()->title)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();

            $item->user_disposition = $user_disposition;
            $data[] = $item;
        }

        return view('applicant.disposition.index', PageLib::config([]), ['data' => $data]);
    }

    public function dt()
    {
        $data = DB::table('disposition_users')->select([
            'disposition_users.user_id',
            'disposition_users.role',
            'disposition_users.note',
            'disposition_users.instruction',
            'disposition_users.status as status_user',
            'disposition_documents.*',
        ])
        ->leftJoin('disposition_documents', 'disposition_documents.id', 'disposition_users.disposition_document_id')
        ->where('disposition_users.user_id', Auth::user()->id)
        ->orWhere('disposition_users.role', Auth::user()->title)
        ->whereNull('disposition_documents.deleted_at')
        ->orderBy('disposition_documents.created_at', 'desc');

        return DataTables::query($data)->addIndexColumn()->make(true);
    }

    public function store(Request $request)
    {
        if ($request->hasFile('uploaded_file')) {
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
            'uploaded_file' => $file_name,
        ]);

        $user_disposition = DispositionUser::create([
            'user_id' => $request->user_id,
            'disposition_document_id' => $docs->id,
            'role' => $request->role,
            'note' => $request->note,
            'instruction' => $request->instruction,
            'status' => 'Menunggu',
        ]);

        $user = User::where('title', $request->role)->first();
        $user->notify(new NewLetter('disposition', $docs->id, $user, 'disposition'));

        $admin = User::where('category', 'admin')->get();
        foreach ($admin as $a) {
            $a->notify(new NewLetter('disposition', $docs->id, $user, 'disposition'));
        }

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        try {
            $check = DispositionUser::where('role', $request->role);

            if ($check->first()) {
                $check->update([
                    'role' => $request->role,
                ]);
            } else {
                DispositionUser::create([
                    'role' => $request->role,
                    'status' => 'Menunggu',
                    'disposition_document_id' => $id,
                ]);
            }

            $data = DispositionDocument::find($id);
            $data->update([
                'status' => 'Disetujui '.Auth::user()->title,
            ]);

            $user = DispositionUser::where('role', Auth::user()->title)
            ->orWhere('user_id', Auth::user()->id);

            $user->update([
                'status' => $request->status,
                'instruction' => $request->instruction.' ('.Auth::user()->title.')',
                'user_id' => Auth::user()->id,
            ]);

            $users = User::where('title', $request->role)->first();
            $users->notify(new NewLetter('disposition', $id, $users, 'disposition'));

            $admin = User::where('category', 'admin')->get();
            foreach ($admin as $a) {
                $a->notify(new NewLetter('disposition', $id, $a, 'disposition'));
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

    public function update_disposition(Request $request, $id)
    {
        $check = DispositionUser::where('role', $request->role);

        if ($check->first()) {
            $check->update([
                    'role' => $request->role,
                ]);
        } else {
            DispositionUser::create([
                    'role' => $request->role,
                    'status' => 'Menunggu',
                    'disposition_document_id' => $id,
                ]);
        }

        $data = DispositionDocument::find($id);
        $data->update([
                'status' => 'Disetujui '.Auth::user()->title,
            ]);

        $user = DispositionUser::where('role', Auth::user()->title)
            ->orWhere('user_id', Auth::user()->id);

        $user->update([
                'status' => $request->status,
                'instruction' => $request->instruction.' ('.Auth::user()->title.')',
                'user_id' => Auth::user()->id,
            ]);

        $users = User::where('title', $request->role)->first();
        $users->notify(new NewLetter('disposition', $id, $users, 'disposition'));

        $admin = User::where('category', 'admin')->get();
        foreach ($admin as $a) {
            $a->notify(new NewLetter('disposition', $id, $a, 'disposition'));
        }

        // return response([
        //     'data' => $data,
        //     'message' => 'Data Terubah',
        // ], 200);
        return redirect()->back();
    }

    public function show($id)
    {
        $data = DispositionDocument::select('*')->where('id', $id)->first();

        $user = DispositionUser::select([
            'disposition_users.role',
            'disposition_users.instruction',
            'users.name',
            'disposition_users.status as status_user',
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

        $pdf = PDF::loadView('/applicant/disposition/print',
        [
            'data' => $data,
        ]
        )->setOptions(['defaultFont' => 'sans-serif'])->setPaper('A4', 'potrait');

        $name = date('Y-m-d_s').' '.'.pdf';

        Storage::put('public/pdf/'.$name, $pdf->output());

        return $pdf->stream($name);
    }
}
