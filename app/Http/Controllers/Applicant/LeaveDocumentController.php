<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Libraries\PageLib;
use App\Models\Admin;
use App\Models\LeaveApproval;
use App\Models\LeaveDocument;
use App\Models\LeaveNote;
use App\Models\Signature;
use App\Models\Unit;
use App\Models\User;
use App\Notifications\NewLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDF;
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

        return view('applicant.leave_document.index', ['data' => $data], PageLib::config([]));
    }

    public function dt()
    {
        $data = DB::table('leave_documents')
        ->select([
            'users.name',
            'leave_documents.*',
        ])
        ->join('users', 'users.id', 'leave_documents.user_id')
        ->leftJoin('leave_approvals', 'leave_approvals.leave_document_id', 'leave_documents.id')
        ->where('users.category', 'karyawan')
        ->where('leave_documents.user_id', Auth::user()->id)
        ->orWhere('leave_approvals.user_id', Auth::user()->id)
        ->whereNull('leave_documents.deleted_at')
        ->orderBy('leave_documents.created_at', 'desc')
        ->groupBy('leave_documents.id', 'users.name');

        return DataTables::query($data)->addIndexColumn()->make(true);
    }

    public function store(Request $request)
    {
        $sign = Signature::select([
            'photo',
        ])
        ->where('user_id', Auth::user()->id)
        ->whereNull('deleted_at')
        ->orderBy('created_at', 'desc')
        ->first();

        $data = LeaveDocument::create([
            'user_id' => Auth::user()->id,
            'unit_id' => $request->unit,
            'reason' => $request->reason,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'address' => $request->address,
            'phone' => $request->phone,
            'permit_type' => $request->permit_type,
            'working_time' => $request->working_time,
            'status' => 'menunggu',
            'signature' => $sign ? $sign : null,
        ]);

        $approver = LeaveApproval::create([
            'leave_document_id' => $data->id,
            'user_id' => $request->chief,
        ]);

        $user = User::where('id', $request->chief)->first();
        $user->notify(new NewLetter('leave', $data->id, $user, 'leave'));

        // $unit = Unit::where('name', 'Kepegawaian')->first();

        // if ($unit) {
        //     $admin = Admin::where('unit_id', $unit->id)->first();
        //     $userAdmin = User::where('id', $admin->user_id)->first();
        //     $userAdmin->notify(new NewLetter('leave', $data->id, $userAdmin, 'leave'));
        // }

        $admin = User::where('category', 'admin')->get();
        foreach ($admin as $a) {
            $a->notify(new NewLetter('leave', $data->id, $a, 'leave'));
        }

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $data = LeaveDocument::find($id);
        $approver = LeaveApproval::where('leave_document_id', $id);
        $sign = DB::table('signatures')->select('photo')->where('user_id', Auth::user()->id)->first();

        if ($request->approver) {
            // dd($sign->first());
            if (Auth::user()->title == 'Ketua') {
                $type = 'PEJABAT';
            } else {
                $type = 'ATASAN';
            }

            $approver->where('user_id', Auth::user()->id);
            $approver->update([
                'note' => $request->approval_note,
                'status' => $request->approval_status,
                'signature' => $sign ? $sign : null,
                'type' => $type,
            ]);

            if ($type = 'ATASAN' && $request->approval_status = 'Disetujui') {
                $ketua = User::where('title', 'Ketua')->whereNull('deleted_at')->first();
                $approver->create([
                    'leave_document_id' => $id,
                    'user_id' => $ketua->id,
                ]);
            }

            $data->update([
                'status' => 'Disetujui oleh '.Auth::user()->name,
            ]);
        } else {
            $data->update([
                'user_id' => Auth::user()->id,
                'unit_id' => $request->unit,
                'reason' => $request->reason,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'address' => $request->address,
                'phone' => $request->phone,
                'permit_type' => $request->permit_type,
                'working_time' => $request->working_time,
                'status' => 'menunggu',
                'signature' => $sign ? $sign : null,
            ]);

            $approver->update([
                'leave_document_id' => $data->id,
                'user_id' => $request->chief,
            ]);

            $user = User::where('id', $request->chief)->first();
            $user->notify(new NewLetter('leave', $id, $user, 'leave'));
        }

        return response([
            'data' => $data,
            'message' => 'Data Terubah',
        ], 200);
    }

    public function show($id)
    {
        $data = DB::table('leave_documents')
        ->select([
            'users.name',
            'users.nip',
            'users.title',
            'units.name as unit',
            'leave_documents.*',
            DB::raw('leave_documents.end_time - leave_documents.start_time as count_time'),
            DB::raw("to_char(leave_documents.created_at , 'dd TMMonth YYYY' ) as tanggal"),
        ])
        ->join('users', 'users.id', 'leave_documents.user_id')
        ->join('units', 'units.id', 'leave_documents.unit_id')
        ->where('leave_documents.id', $id)
        ->whereNull('leave_documents.deleted_at')
        ->first();

        $user = LeaveApproval::select([
            'leave_approvals.user_id',
            'users.name as chief',
            'users.nip',
            'leave_approvals.status as approval_status',
            'leave_approvals.type as approval_type',
            'leave_approvals.signature',
            'leave_approvals.note',
        ])
        ->join('users', 'users.id', 'leave_approvals.user_id')
        ->where('leave_approvals.leave_document_id', $id)
        ->whereNull('leave_approvals.deleted_at')
        ->get();

        $notes = LeaveNote::select([
            'amount',
            'remain',
            'type',
            'datetime',
        ])
        ->where('leave_document_id', $id)
        ->whereNull('deleted_at')
        ->orderBy('created_at', 'desc')
        ->get();

        $data->approval = $user ? $user : [];
        $data->leave_notes = $notes ? $notes : [];

        return response([
            'data' => $data,
            'message' => 'Data Terubah',
        ], 200);
    }

    public function destroy($id)
    {
        $data = LeaveDocument::find($id);
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

        $data = DB::table('leave_documents')
        ->select([
            'users.name',
            'users.nip',
            'users.title',
            'units.name as unit',
            'leave_documents.*',
            DB::raw('leave_documents.end_time - leave_documents.start_time as count_time'),
            DB::raw("to_char(leave_documents.created_at , 'dd TMMonth YYYY' ) as tanggal"),
        ])
        ->join('users', 'users.id', 'leave_documents.user_id')
        ->join('units', 'units.id', 'leave_documents.unit_id')
        ->where('leave_documents.id', $id)
        ->whereNull('leave_documents.deleted_at')
        ->first();

        $user = LeaveApproval::select([
            'leave_approvals.user_id',
            'users.name as chief',
            'users.nip',
            'users.title',
            'leave_approvals.status as approval_status',
            'leave_approvals.type as approval_type',
            'leave_approvals.signature',
            'leave_approvals.note',
        ])
        ->join('users', 'users.id', 'leave_approvals.user_id')
        ->where('leave_approvals.leave_document_id', $id)
        ->whereNull('leave_approvals.deleted_at')
        ->get();

        $notes = LeaveNote::select([
            'amount',
            'remain',
            'type',
            'datetime',
        ])
        ->where('leave_document_id', $id)
        ->whereNull('deleted_at')
        ->orderBy('created_at', 'desc')
        ->get();

        $data->approval = $user ? $user : [];
        $data->leave_notes = $notes ? $notes : [];

        $pdf = PDF::loadView('/applicant/leave_document/print',
        [
                'data' => $data,
                'logo' => base64_encode(file_get_contents(public_path('logo.png'))),
            ]
        )->setOptions(['defaultFont' => 'sans-serif'])->setPaper('A4', 'potrait');

        $name = date('Y-m-d_s').' '.'.pdf';

        Storage::put('public/pdf/'.$name, $pdf->output());

        return $pdf->stream($name);
    }

    public function update_approval(Request $request, $id)
    {
        $data = LeaveDocument::find($id);

        $datetime = $request->date.' '.$request->time;

        if (Auth::user()->title == 'Ketua') {
            $data->update([
                'chief_approval' => $request->approve,
            ]);
        } else {
            $data->update([
                'officer_approval' => $request->approve,
            ]);
        }

        return response([
            'data' => $data,
            'message' => 'Data Terubah',
        ], 200);
    }
}
