<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class LeaveDocumentController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $data = DB::table('leave_documents')
        ->select('*')
        ->join('users', 'users.id', 'leave_documents.user_id')
        ->get();

        return view('admin.leave_document.index', ['data' => $data]);
    }

    public function dt()
    {
        $data = DB::table('leave_documents')
        ->select([
            'users.name',
            'leave_documents.*',
        ])
        ->join('users', 'users.id', 'leave_documents.user_id')
        ->where('users.category', 'karyawan')
        ->whereNull('leave_documents.deleted_at');

        return DataTables::query($data)->addIndexColumn()->make(true);
    }

    public function update_approval($id)
    {
        $signature = DB::table('signatures')->select('photo')->where('user_id', Auth::id())->first();
        $data = ExitPermitDocument::find($id);

        if (Auth::user()->title == 'Ketua') {
            $data->update([
                'chief_signature' => $signature,
            ]);
        } else {
            $data->update([
                'secretary_signature' => $signature,
            ]);
        }

        return response([
            'data' => $data,
            'message' => 'Data Terubah',
        ], 200);
    }
}
