<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Libraries\IdDate;
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

        $notify = DB::table('notifications')->where('notifiable_id', Auth::user()->id)->whereNull('read_at')->get();
        foreach ($notify as $item1) {
            $dat = json_decode($item1->data);
            if ($dat->type == 'leave') {
                $notify1 = DB::table('notifications')->where('id', $item1->id);
                $notify1->update(['read_at' => date('Y-m-d H:i:s')]);
            }
        }

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
            ->join('leave_approvals', 'leave_approvals.leave_document_id', 'leave_documents.id')
            ->where('users.category', 'karyawan')
            ->whereNull('leave_documents.deleted_at')
            ->where(function ($query) {
                $query->where('leave_documents.user_id', Auth::user()->id)
                    ->orWhere('leave_approvals.user_id', Auth::user()->id);
            })
            ->orderBy('leave_documents.created_at', 'desc')
            ->groupBy('leave_documents.id', 'users.name');

        return DataTables::query($data)->addIndexColumn()->make(true);
    }

    public function store(Request $request)
    {
        $sign = Signature::select([
            'photo'
        ])
            ->where('user_id', Auth::user()->id)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->first();

        if ($sign) {
            $signature = $sign->photo;
        } else {
            $signature = null;
        }

        $data = LeaveDocument::create([
            'user_id' => Auth::user()->id,
            'reason' => $request->reason,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'address' => $request->address,
            'phone' => $request->phone,
            'permit_type' => $request->permit_type,
            'working_time' => $request->working_time,
            'leave_long' => $request->leave_long,
            'status' => 'menunggu',
            'signature' => $signature,
        ]);

        $approver = LeaveApproval::create([
            'leave_document_id' => $data->id,
            'user_id' => $request->chief,
            'type' => "ATASAN"
        ]);

        $user = User::where('id', $request->chief)->first();
        $user->notify(new NewLetter('leave', $data->id, $user, 'leave'));

        $admin = Admin::where('role', 'Kepegawaian')->get();
        foreach ($admin as $a) {
            $userAdm = User::where('id', $a->user_id)->first();
            $userAdm->notify(new NewLetter('leave', $data->id, $userAdm, 'leave'));
        }

        $super = Admin::where('role', null)->first();
        $userSup = User::where('id', $super->user_id)->first();
        if ($userSup) {
            $userSup->notify(new NewLetter('leave', $data->id, $userSup, 'leave'));
        }

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $data = LeaveDocument::where('id', $id);
        $approver = LeaveApproval::where('leave_document_id', $id);
        $sign = Signature::where('user_id', Auth::user()->id)->first();


        if ($sign) {
            $signature = $sign->photo;
        } else {
            $signature = null;
        }

        if ($request->approver) {
            if ($request->chief_final) {
                $types = "ATASAN";
            } else {
                $types = "PEJABAT";
            }

            $approver->where('user_id', Auth::user()->id);
            $approver->update([
                'note' => $request->approval_note,
                'status' => $request->approval_status,
                'signature' => $signature,
                'type' => $types,
            ]);

            if ($request->chief_final && $request->approval_status = 'Disetujui') {
                $approver->create([
                    'leave_document_id' => $id,
                    'user_id' => $request->chief_final,
                    'note' => null,
                    'status' => null,
                    'signature' => null,
                    'type' => 'PEJABAT',
                ]);
            } else if ($approver->where('user_id', Auth::user()->id)->first()->type == "PEJABAT" && $request->approval_status = 'Disetujui') {
                $approver->update([
                    'note' => $request->approval_note,
                    'status' => $request->approval_status,
                    'signature' => $signature,
                    'type' => "PEJABAT",
                ]);
            }

            $data->update([
                'status' => 'Disetujui oleh ' . Auth::user()->name,
            ]);

            if ($request->chief_final) {
                $user = User::where("id", $request->chief_final)->first();
                $user->notify(new NewLetter('leave', $id, $user, 'leave'));
            }
        } else {
            $data->update([
                'user_id' => Auth::user()->id,
                'reason' => $request->reason,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'address' => $request->address,
                'phone' => $request->phone,
                'permit_type' => $request->permit_type,
                'working_time' => $request->working_time,
                'leave_long' => $request->leave_long,
                'status' => 'menunggu',
                'signature' => $signature,
            ]);

            $approver->update([
                'leave_document_id' => $data->first()->id,
                'user_id' => $request->chief ? $request->chief : $approver->first()->user_id,
            ]);

            $chief_id = $request->chief ? $request->chief : $approver->first()->user_id;

            // $user = User::where('id', $request->chief)->first();
            // $user->notify(new NewLetter('leave', $id, $user, 'leave'));
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

        if ($user) {
            $appr = $user;
        } else {
            $appr = [];
        }

        $date = IdDate::translate($data->created_at);
        $data->tanggal = $date->format('j F Y');

        $data->approval = $appr;
        $data->leave_notes = $notes ? $notes : [];

        return response([
            'data' => $data,
            'message' => 'Data Terubah',
        ], 200);
    }

    public function destroy($id)
    {
        try {
            $data = LeaveDocument::find($id);

            DB::transaction(function () use ($data) {
                $data->delete();
            });

            if ($data->trashed()) {
                return response([
                    'message' => 'Successfully deleted!',
                ], 200);
            }

        } catch (\Exception $e) {

            return response([
                'message' => $e->getMessage(),
            ], 500);
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

    public function update_approval(Request $request, $id)
    {
        $data = LeaveDocument::find($id);

        $datetime = $request->date . ' ' . $request->time;

        $user = User::where('id', $data->user_id)->first();

        if (Auth::user()->title == 'Ketua') {
            $data->update([
                'chief_approval' => $request->approve,
            ]);

            $user->notify(new NewLetter('leave', $id, $user, 'leave'));
        } else {
            $data->update([
                'officer_approval' => $request->approve,
            ]);

            $user->notify(new NewLetter('leave', $id, $user, 'leave'));
        }


        return response([
            'data' => $data,
            'message' => 'Data Terubah',
        ], 200);
    }
}
