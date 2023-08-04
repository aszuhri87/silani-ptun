<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Libraries\IdDate;
use App\Libraries\PageLib;
use App\Models\Admin;
use App\Models\ExitPermitDocument;
use App\Models\Unit;
use App\Models\User;
use App\Notifications\NewLetter;
use Carbon\Carbon;
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
        setlocale(LC_TIME, 'Indonesia');
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

        $notify = DB::table('notifications')->where('notifiable_id', Auth::user()->id)->whereNull('read_at')->get();
        foreach ($notify as $item1) {
            $dat = json_decode($item1->data);
            if ($dat->type == 'exit') {
                $notify1 = DB::table('notifications')->where('id', $item1->id);
                $notify1->update(['read_at' => date('Y-m-d H:i:s')]);
            }
        }

        return view('applicant.exit-permit-document.index', ['data' => $data], PageLib::config([]));
    }

    public function dt()
    {
        $data = DB::table('exit_permit_documents')
        ->select([
            'exit_permit_documents.id',
            'users.name',
            'units.name as unit',
            'exit_permit_documents.*',
            DB::raw("to_char(exit_permit_documents.datetime, 'TMDay/dd TMMonth YYYY') as date"),
            DB::raw("to_char(exit_permit_documents.datetime, 'TMDay TMMonth YYYY') as date_sign"),
            DB::raw("to_char(exit_permit_documents.datetime, 'HH:mi') as time"),
            DB::raw("
                CASE WHEN exit_permit_documents.approver = '".Auth::user()->name."' AND exit_permit_documents.status IS NULL THEN 'Menunggu Konfirmasi Anda'
                WHEN exit_permit_documents.approver != users.name AND exit_permit_documents.status IS NULL THEN CONCAT('Menunggu persetujuan ', exit_permit_documents.approver)
                ELSE exit_permit_documents.status END as status
            "),
        ])
        ->leftJoin('users', 'users.id', 'exit_permit_documents.user_id')
        ->leftJoin('units', 'units.id', 'exit_permit_documents.unit_id')
        ->where(function ($query) {
            $query->where('exit_permit_documents.user_id', Auth::user()->id)
            ->orWhere('exit_permit_documents.approver', Auth::user()->name);
        })
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

        $unit = Unit::where('name', 'ilike', '%Kepegawaian%')->orWhere('name', 'ilike', '%kepegawaian%')->first();

        $admin = Admin::where('unit_id', $unit->id)->get();
        foreach ($admin as $a) {
            $userAdm = User::where('id', $a->user_id)->first();
            $userAdm->notify(new NewLetter('exit', $data->id, $userAdm, 'exit'));
        }

        $super = Admin::where('unit_id', null)->first();
        $userSup = User::where('category', 'admin')->where('id', $super->user_id)->first();
        $userSup->notify(new NewLetter('exit', $data->id, $userSup, 'exit'));

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
        $data = ExitPermitDocument::
        select([
            'exit_permit_documents.id',
            'users.name',
            'users.nip',
            'users.gol',
            'units.name as unit',
            'exit_permit_documents.datetime',
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

        $approver = User::where('name', 'ilike', '%'.$data->approver)->first();
        $data->title = strtoupper($approver->title);

        $date = IdDate::translate($data->datetime);
        $data->date = $date->format('l/j F Y');
        $data->date_sign = $date->format('l/j F Y');

        return response([
            'data' => $data,
            'message' => 'Data loaded',
        ], 200);
    }

    public function destroy($id)
    {
        $data = ExitPermitDocument::find($id);
        $data->delete();

        if ($data->trashed()) {
            return response([
                'message' => 'Successfully deleted!',
            ], 200);
        }
    }

    public function print($id)
    {
        date_default_timezone_set('Asia/Jakarta');

        $data = ExitPermitDocument::select([
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

        $approver = User::where('name', 'ilike', '%'.$data->approver)->first();
        $data->title =  strtoupper($approver->title);

        $date = IdDate::translate($data->datetime);
        $data->datetime = $date->format('l/j F Y');
        $data->date = $date->format('l/j F Y');

        $pdf = PDF::loadView('/applicant/exit-permit-document/print',
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
        $signature = DB::table('signatures')->select('photo')->where('user_id', Auth::user()->id)->first();

        $data = ExitPermitDocument::find($id);

        $data->update([
            'signature' => $signature ? $signature->photo : null,
            'status' => $request->status,
            'approver' => Auth::user()->name,
            'notes' => $request->notes,
        ]);

        $user = User::where('id', $data->user_id)->first();
        $user->notify(new NewLetter('exit', $id, $user, 'exit'));

        return response([
            'data' => $data,
            'message' => 'Data Terubah',
        ], 200);
    }
}
