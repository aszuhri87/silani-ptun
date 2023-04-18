<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveApproval;
use App\Models\LeaveDocument;
use App\Models\LeaveNote;
use Illuminate\Http\Request;
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
        // ->where('users.category', 'admin')
        ->whereNull('leave_documents.deleted_at');

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

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        // dd($request->remain);
        $data = LeaveNote::where('leave_document_id', $id);
        $check = $data->first();

        if (!$check) {
            foreach ($request->type as $i => $item) {
                $new = LeaveNote::create([
                    'type' => $item,
                    'amount' => $request->amount[$i],
                    'leave_document_id' => $id,
                    // 'remain' => $item == 'Tahunan' ? $request->remain[$i] : null,
                    'datetime' => date('Y-m-d H:i:s'),
                ]);

                if ($item == 'Tahunan-'.$i) {
                    foreach ($request->remain as $key => $item2) {
                        $remain = LeaveNote::where('id', $new->id)->where('type', 'Tahunan-'.$i);
                        $remain->update([
                            'remain' => $request->remain[$i],
                        ]);
                    }
                }
            }
        } else {
            foreach ($request->type as $i => $item) {
                $data->update([
                    'type' => $item,
                    'amount' => $request->amount[$i],
                    'leave_document_id' => $id,
                    // 'remain' => $request->remain[$i] ? $request->remain[$i] : null,
                    'datetime' => date('Y-m-d H:i:s'),
                ]);

                if ($item == 'Tahunan-'.$i) {
                    foreach ($request->remain as $key => $item2) {
                        $remain = LeaveNote::where('id', $new->id)->where('type', 'Tahunan-'.$i);
                        $remain->update([
                            'remain' => $request->remain[$i],
                        ]);
                    }
                }
            }
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

    public function update_leave_note(Request $request, $id)
    {
        $note = LeaveNote::where('leave_document_id', $id);

        if ($note) {
            foreach ($request->type as $key => $item) {
                $note->update([
                    'type' => $item,
                    'remain' => $request->remain[$key],
                    'amount' => $request->amount[$key],
                    'leave_document_id' => $id,
                ]);
            }
        } else {
            foreach ($request->type as $key => $item) {
                LeaveNote::create([
                    'type' => $item,
                    'remain' => $request->remain[$key],
                    'amount' => $request->amount[$key],
                    'leave_document_id' => $id,
                ]);
            }
        }

        return response([
            'data' => $note,
            'message' => 'Data Terubah',
        ], 200);
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

        $pdf = PDF::loadView('/admin/leave_document/print',
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
