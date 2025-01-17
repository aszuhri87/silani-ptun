<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Libraries\IdDate;
use App\Libraries\PageLib;
use App\Models\ExitPermitDocument;
use App\Models\LeaveApproval;
use App\Models\LeaveDocument;
use App\Models\LeaveNote;
use App\Models\Signature;
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

        $notify = DB::table('notifications')->where('notifiable_id', Auth::user()->id)->whereNull('read_at')->get();
        foreach ($notify as $item1) {
            $dat = json_decode($item1->data);
            if ($dat->type == 'leave') {
                $notify1 = DB::table('notifications')->where('id', $item1->id);
                $notify1->update(['read_at' => date('Y-m-d H:i:s')]);
            }
        }

        return view('admin.leave_document.index', PageLib::config([]), ['data' => $data]);
    }

    public function dt()
    {
        $data = DB::table('leave_documents')
            ->select([
                'users.name',
                'leave_documents.*',
                DB::raw("to_char(leave_documents.start_time, 'dd-mm-yyyy') as start_time"),
                DB::raw("to_char(leave_documents.end_time, 'dd-mm-yyyy') as end_time"),

            ])
            ->join('users', 'users.id', 'leave_documents.user_id')
            ->whereNull('leave_documents.deleted_at')
            ->orderBy('leave_documents.created_at', 'desc');

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
            'user_id' => $request->user,
            'reason' => $request->reason,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'address' => $request->address,
            'phone' => $request->phone,
            'permit_type' => $request->permit_type,
            'working_time' => $request->working_time,
            'status' => 'menunggu',
            'leave_long' => $request->leave_long,
            'signature' => $sign ? $sign : null,
            'letter_head' => $request->letter_head
        ]);

        $approver = LeaveApproval::create([
            'leave_document_id' => $data->id,
            'user_id' => $request->chief,
        ]);

        $user = User::where('id', $request->chief)->first();
        $user->notify(new NewLetter('leave', $data->id, $user, 'leave'));

        $admin = User::where('category', 'admin')->get();
        foreach ($admin as $a) {
            $a->notify(new NewLetter('leave', $data->id, $a, 'leave'));
        }

        $datas = LeaveNote::where('leave_document_id', $data->id);
        $check = $datas->first();

        if (!$check) {
            foreach ($request->type as $i => $item) {
                $new = LeaveNote::create([
                    'type' => $item,
                    'amount' => $request->amount[$i],
                    'leave_document_id' => $data->id,
                    'datetime' => date('Y-m-d H:i:s'),
                ]);

                if ($item == 'Tahunan-' . $i) {
                    foreach ($request->remain as $key => $item2) {
                        $remain = LeaveNote::where('id', $new->id)->where('type', 'Tahunan-' . $i);
                        $remain->update([
                            'remain' => $request->remain[$i],
                        ]);
                    }
                }
            }
        } else {
            foreach ($request->type as $i => $item) {
                $data_type = LeaveNote::where('type', $item)->where('leave_document_id', $data->id);
                $data_type->update([
                    'type' => $item,
                    'amount' => $request->amount[$i],
                    'leave_document_id' => $data->id,
                    'datetime' => date('Y-m-d H:i:s'),
                ]);

                if ($item == 'Tahunan-' . $i) {
                    foreach ($request->remain as $key => $item2) {
                        $remain = LeaveNote::where('id', $check->id)->where('type', 'Tahunan-' . $i);
                        $remain->update([
                            'remain' => $request->remain[$i],
                        ]);
                    }
                }
            }
        }

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $data_doc = LeaveDocument::find($id);
        $approver = LeaveApproval::where('leave_document_id', $id);
        $sign = Signature::select('photo')->where('user_id', $request->user)->first();

        if ($request->approver) {
            if (Auth::user()->title == 'Ketua') {
                $type = 'PEJABAT';
            } else {
                $type = 'ATASAN';
            }

            $approver->where('user_id', Auth::user()->id);
            $approver->update([
                'note' => $request->approval_note,
                'status' => $request->approval_status,
                'type' => $type,
            ]);

            if ($type = 'ATASAN' && $request->approval_status = 'Disetujui') {
                $ketua = User::where('title', 'Ketua')->whereNull('deleted_at')->first();
                $approver->create([
                    'leave_document_id' => $id,
                    'user_id' => $ketua->id,
                ]);
            }

            $data_doc->update([
                'status' => 'Disetujui oleh ' . Auth::user()->name,
            ]);
        } else {
            $data_doc->update([
                'user_id' => $request->user ? $request->user : $data_doc['user_id'],
                'reason' => $request->reason,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'address' => $request->address,
                'phone' => $request->phone,
                'permit_type' => $request->permit_type,
                'working_time' => $request->working_time,
                'leave_long' => $request->leave_long,
                'status' => 'menunggu',
                // 'signature' => $sign ? $sign : null,
                'letter_head' => $request->letter_head

            ]);

            $approver->update([
                'leave_document_id' => $data_doc->id,
                'user_id' => $request->chief ? $request->chief : $approver->first()->user_id,
            ]);
        }

        $data = LeaveNote::where('leave_document_id', $id);
        $check = $data->first();


        if (!$check) {
            foreach ($request->type as $i => $item) {
                $new = LeaveNote::create([
                    'type' => $item,
                    'amount' => $request->amount[$i],
                    'leave_document_id' => $id,
                    'datetime' => date('Y-m-d H:i:s'),
                ]);

                if ($item == 'Tahunan-' . $i) {
                    foreach ($request->remain as $key => $item2) {
                        $remain = LeaveNote::where('id', $new->id)->where('type', 'Tahunan-' . $i);
                        $remain->update([
                            'remain' => $request->remain[$i],
                        ]);
                    }
                }
            }
        } else {
            foreach ($request->type as $i => $item) {
                $data_type = LeaveNote::where('type', $item)->where('leave_document_id', $id);
                $data_type->update([
                    'type' => $item,
                    'amount' => $request->amount[$i],
                    'leave_document_id' => $id,
                    'datetime' => date('Y-m-d H:i:s'),
                ]);

                if ($item == 'Tahunan-' . $i) {
                    foreach ($request->remain as $key => $item2) {
                        $remain = LeaveNote::where('id', $check->id)->where('type', 'Tahunan-' . $i);
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
                'leave_documents.*',
                DB::raw("to_char(leave_documents.start_time, 'dd-mm-yyyy') as start_time"),
                DB::raw("to_char(leave_documents.end_time, 'dd-mm-yyyy') as end_time"),
                DB::raw('leave_documents.end_time - leave_documents.start_time as count_time'),
            ])
            ->join('users', 'users.id', 'leave_documents.user_id')
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


        $date = IdDate::translate($data->created_at);
        $data->tanggal = $date->format('j F Y');

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

        if ($data->trashed()) {
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
                'leave_documents.*',
                DB::raw("to_char(leave_documents.start_time, 'dd-mm-yyyy') as start_time"),
                DB::raw("to_char(leave_documents.end_time, 'dd-mm-yyyy') as end_time"),
                DB::raw('leave_documents.end_time - leave_documents.start_time as count_time'),
            ])
            ->join('users', 'users.id', 'leave_documents.user_id')
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

        $signature_pejabat = null;
        $signature_atasan = null;
        $signature_pemohon = null;

        if ($data->signature) {
            $signature_pemohon = base64_encode(file_get_contents(public_path('signature/' . $data->signature)));
        } else {
            $signature_pemohon = null;
        }

        foreach ($user as $u) {
            if ($u->approval_type == 'PEJABAT') {
                if ($u->signature) {
                    $signature_pejabat = base64_encode(file_get_contents(public_path('signature/' . $u->signature)));
                } else {
                    $signature_pejabat = null;
                }
            }

            if ($u->approval_type == 'ATASAN') {
                if ($u->signature) {
                    $signature_atasan = base64_encode(file_get_contents(public_path('signature/' . $u->signature)));
                } else {
                    $signature_atasan = null;
                }
            }
        }

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

        $date = IdDate::translate($data->created_at);
        $data->tanggal = $date->format('j F Y');

        $data->approval = $user ? $user : [];
        $data->leave_notes = $notes ? $notes : [];

        $pdf = PDF::loadView(
            '/admin/leave_document/print',
            [
                'data' => $data,
                'logo' => base64_encode(file_get_contents(public_path('logo.png'))),
                'sign_atasan' => $signature_atasan,
                'sign_pejabat' => $signature_pejabat,
                'sign_pemohon' => $signature_pemohon
            ]
        )->setOptions(['defaultFont' => 'sans-serif'])->setPaper('A4', 'potrait');

        $name = date('Y-m-d_s') . ' ' . '.pdf';

        Storage::put('public/pdf/' . $name, $pdf->output());

        return $pdf->stream($name);
    }
}
