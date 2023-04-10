<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        // ->join('admins', 'admins.id', 'exit_permit_documents.admin_id')
        ->whereNull('users.deleted_at')
        ->get();

        return view('admin.exit-permit-document.index', ['data' => $data]);
    }

    public function dt()
    {
        $data = DB::table('exit_permit_documents')
        ->select([
            'exit_permit_documents.id',
            'users.name',
            'units.name as unit',
            'exit_permit_documents.datetime',
        ])
        ->leftJoin('users', 'users.id', 'exit_permit_documents.user_id')
        ->leftJoin('units', 'units.id', 'exit_permit_documents.unit_id')
        ->whereNull('exit_permit_documents.deleted_at');

        // dd($data->get());

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
        ]);

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $data = ExitPermitDocument::find($id);

        $datetime = $request->date.' '.$request->time;

        $data->update([
            'user_id' => $request->name,
            'unit_id' => $request->unit,
            'reason' => $request->reason,
            'datetime' => $datetime,
        ]);

        return response([
            'data' => $data,
            'message' => 'Data Terubah',
        ], 200);
    }

    public function update_approval($id)
    {
        $signature = DB::table('signatures')->select('photo')->where('user_id', Auth::id())->first();

        $data = ExitPermitDocument::find($id);

        $data->update([
            'signature' => $signature,
            'status' => 'Disetujui',
            'approver' => Auth::user()->name,
        ]);

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
            'units.name as unit',
            'exit_permit_documents.datetime',
            'exit_permit_documents.reason',
            'exit_permit_documents.approver',
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
            'exit_permit_documents.reason',
        ])
        ->leftJoin('users', 'users.id', 'exit_permit_documents.user_id')
        ->leftJoin('units', 'units.id', 'exit_permit_documents.unit_id')
        ->where('exit_permit_documents.id', $id)
        ->whereNull('exit_permit_documents.deleted_at')
        ->first();

        $pdf = PDF::loadView('/applicant/exit-permit-document/print',
        [
                'data' => $data,
                'logo' => base64_encode(file_get_contents(public_path('logo.png'))),
            ]
        )->setOptions(['defaultFont' => 'sans-serif'])->setPaper('A4', 'potrait');

        $name = date('Y-m-d_s').' '.'.pdf';

        Storage::put('public/pdf/'.$name, $pdf->output());

        return $pdf->stream($name);
    }
}
