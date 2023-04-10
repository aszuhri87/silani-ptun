<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Libraries\PageLib;
use App\Models\OutgoingLetter;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDF;
use Yajra\DataTables\Facades\DataTables;

class OutgoingLetterController extends Controller
{
    public function index()
    {
        $data = DB::table('outgoing_letters')->select('*')
        ->whereNull('deleted_at')
        ->where('user_id', Auth::user()->id)
        ->orderBy('created_at', 'desc')
        ->get();

        return view('applicant.outgoing_letter.index', ['data' => $data], PageLib::config([]));
    }

    public function dt()
    {
        $data = DB::table('outgoing_letters')
        ->select([
            '*',
        ])
        ->where('user_id', Auth::user()->id)
        ->whereNull('deleted_at')
        ->orderBy('created_at', 'desc');

        return DataTables::query($data)->addIndexColumn()->make(true);
    }

    public function store(Request $request)
    {
        $file_name = null;

        if ($request->uploaded_file) {
            $file = $request->file('uploaded_file');
            $file_name = $file->getClientOriginalName();
            $file->move(public_path().'/files/', $file_name);
        }

        $docs = OutgoingLetter::create([
            'letter_type' => $request->letter_type,
            'letter_number' => $request->letter_number,
            'date_letter' => $request->date_letter,
            'date_received' => $request->date_received,
            'user_id' => $request->user_id,
            'description' => $request->description,
            'agenda_number' => $request->agenda_number,
            'uploaded_document' => $file_name,
        ]);

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        try {
            if ($request->hasFile('uploaded_file')) {
                $file = $request->file('uploaded_file');
                $file_name = $file->getClientOriginalName();
                $file->move(public_path().'/files/', $file_name);
            }

            $data = OutgoingLetter::find($id);
            $data->update([
                'letter_type' => $request->letter_type,
                'date_letter' => $request->date_letter,
                'letter_number' => $request->letter_number,
                'date_received' => $request->date_received,
                'user_id' => $request->user_id,
                'description' => $request->description,
                'agenda_number' => $request->agenda_number,
                'uploaded_file' => $file_name ? $file_name : null,
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

    public function show($id)
    {
        $data = OutgoingLetter::select([
            'outgoing_letters.*',
            'users.name',
        ])
        ->leftJoin('users', 'users.id', 'outgoing_letters.user_id')
        ->where('outgoing_letters.id', $id)
        ->whereNull('outgoing_letters.deleted_at')
        ->first();

        return response()->json([
            'data' => $data,
        ]);
    }

    public function destroy($id)
    {
        try {
            $result = OutgoingLetter::find($id);

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

    // public function print($id)
    // {
    //     date_default_timezone_set('Asia/Jakarta');

    //     $data = OutgoingLetter::select('*')->where('id', $id)->first();

    //     $user = OutgoingLetter::select([
    //         'outgoing_letter_users.role',
    //         'outgoing_letter_users.instruction',
    //         'users.name',
    //     ])
    //     ->leftJoin('users', 'users.id', 'outgoing_letter_users.user_id')
    //     ->whereNull('outgoing_letter_users.deleted_at')
    //     ->get();

    //     $data->outgoing_letter = $user;

    //     $pdf = PDF::loadView('/applicant/outgoing_letter/print',
    //     [
    //         'data' => $data,
    //     ]
    //     )->setOptions(['defaultFont' => 'sans-serif'])->setPaper('A4', 'potrait');

    //     $name = date('Y-m-d_s').' '.'.pdf';

    //     Storage::put('public/pdf/'.$name, $pdf->output());

    //     return $pdf->stream($name);
    // }
}
