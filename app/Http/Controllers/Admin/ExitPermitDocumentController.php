<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Libraries\PageLib;
use App\Models\ExitPermitDocument;
use App\Models\User;
use App\Notifications\NewLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDF;
use Yajra\DataTables\Facades\DataTables;

class ExitPermitDocumentController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $data = DB::table('exit_permit_documents')
        ->select('*')
        ->join('users', 'users.id', 'exit_permit_documents.user_id')
        ->join('units', 'units.id', 'exit_permit_documents.unit_id')
        ->whereNull('users.deleted_at')
        ->get();

        return view('admin.exit-permit-document.index', PageLib::config([]), ['data' => $data], PageLib::config([]));
    }

    public function dt()
    {
        $data = DB::table('exit_permit_documents')
        ->select([
            'exit_permit_documents.id',
            'users.name',
            'units.name as unit',
            'exit_permit_documents.*',
            DB::raw("
                CASE WHEN exit_permit_documents.approver = '".Auth::user()->name."' AND exit_permit_documents.status IS NULL THEN 'Menunggu Konfirmasi Anda'
                WHEN exit_permit_documents.approver != users.name AND exit_permit_documents.status IS NULL THEN CONCAT('Menunggu persetujuan ', exit_permit_documents.approver)
                ELSE exit_permit_documents.status END as status
            "),
        ])
        ->leftJoin('users', 'users.id', 'exit_permit_documents.user_id')
        ->leftJoin('units', 'units.id', 'exit_permit_documents.unit_id')
        ->whereNull('exit_permit_documents.deleted_at')
        ->orderBy('exit_permit_documents.created_at', 'desc');

        return DataTables::query($data)->addIndexColumn()->make(true);
    }

    public function store(Request $request)
    {
        $datetime = $request->date.' '.$request->time;

        $data = ExitPermitDocument::create([
            'user_id' => $request->name,
            'unit_id' => $request->unit,
            'reason' => $request->reason,
            'datetime' => $datetime,
            'approver' => $request->chief,
        ]);

        $user = User::where('name', $request->chief)->first();
        $user->notify(new NewLetter('exit', $data->id, $user, 'exit'));

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $data = ExitPermitDocument::find($id);

        $datetime = $request->date.' '.$request->time;

        $item = $data->first();

        $data->update([
            'user_id' => $request->name ? $request->name : $item->name,
            'unit_id' => $request->unit ? $request->unit : $item->unit_id,
            'reason' => $request->reason ? $request->reason : $item->reason,
            'datetime' => $datetime ? $datetime : $item->datetime,
            'approver' => $request->chief ? $request->chief : $item->approver,
        ]);

        $user = User::where('name', $request->chief)->first();
        $user->notify(new NewLetter('exit', $id, $user, 'exit'));

        return response([
            'data' => $data,
            'message' => 'Data Terubah',
        ], 200);
    }

    public function show($id)
    {
        $data = DB::table('exit_permit_documents')
        ->select([
            'exit_permit_documents.id',
            'users.name',
            'users.nip',
            'users.gol',
            'units.name as unit',
            DB::raw("to_char(exit_permit_documents.datetime, 'TMDay/dd TMMonth YYYY') as date"),
            DB::raw("to_char(exit_permit_documents.datetime, 'HH:mi') as time"),
            'exit_permit_documents.reason',
            'exit_permit_documents.approver',
            'exit_permit_documents.status',
            'exit_permit_documents.signature',
            'exit_permit_documents.notes',
        ])
        ->where('exit_permit_documents.id', $id)
        ->leftJoin('users', 'users.id', 'exit_permit_documents.user_id')
        ->leftJoin('units', 'units.id', 'exit_permit_documents.unit_id')
        ->whereNull('users.deleted_at')
        ->first();

        return response([
            'data' => $data,
            'message' => 'Data Terubah',
        ], 200);
    }

    public function destroy($id)
    {
        $data = ExitPermitDocument::find($id);
        $data->delete();

        if ($result->trashed()) {
            return response([
                'message' => 'Successfully deleted!',
            ], 200);
        }
    }

    public function print($id)
    {
        date_default_timezone_set('Asia/Jakarta');

        $data = DB::table('exit_permit_documents')
        ->select([
            'exit_permit_documents.id',
            'users.name',
            'units.name as unit',
            'exit_permit_documents.datetime',
            'users.nip',
            'users.gol',
            'exit_permit_documents.reason',
            'exit_permit_documents.approver',
            'exit_permit_documents.status',
            'exit_permit_documents.signature',
            DB::raw("to_char(exit_permit_documents.datetime, 'TMDay/dd TMMonth YYYY') as date"),
            DB::raw("to_char(exit_permit_documents.datetime, 'HH:mi') as time"),
        ])
        ->leftJoin('users', 'users.id', 'exit_permit_documents.user_id')
        ->leftJoin('units', 'units.id', 'exit_permit_documents.unit_id')
        ->where('exit_permit_documents.id', $id)
        ->whereNull('exit_permit_documents.deleted_at')
        ->first();

        if ($data->signature) {
            $sign = base64_encode(file_get_contents(public_path('/signature/'.$data->signature)));
        } else {
            $sign = null;
        }

        $pdf = PDF::loadView('/admin/exit-permit-document/print',
        [
                'data' => $data,
                'logo' => base64_encode(file_get_contents(public_path('logo.png'))),
                'signature' => $sign,
            ]
        )->setOptions(['defaultFont' => 'sans-serif'])->setPaper('A4', 'potrait');

        $name = date('Y-m-d_s').' '.'.pdf';

        Storage::put('public/pdf/'.$name, $pdf->output());

        return $pdf->stream($name);
    }

    public function update_approval(Request $request, $id)
    {
        $signature = DB::table('signatures')->select('photo')->where('user_id', Auth::id())->first();

        $data = ExitPermitDocument::find($id);

        $data->update([
            'signature' => (string) $signature->photo,
            'status' => $request->status,
            'approver' => Auth::user()->name,
            'notes' => $request->notes,
        ]);

        return response([
            'data' => $data,
            'message' => 'Data Terubah',
        ], 200);
    }
}
