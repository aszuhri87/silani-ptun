<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Libraries\PageLib;
use App\Models\Admin;
use App\Models\OutgoingLetter;
use App\Models\Unit;
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

class OutgoingLetterController extends Controller
{
    public function index()
    {
        $data = DB::table('outgoing_letters')->select('*')
            ->whereNull('deleted_at')
            ->where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $notify = DB::table('notifications')->where('notifiable_id', Auth::user()->id)->whereNull('read_at')->get();
        foreach ($notify as $item1) {
            $dat = json_decode($item1->data);
            if ($dat->type == 'outgoing') {
                $notify1 = DB::table('notifications')->where('id', $item1->id);
                $notify1->update(['read_at' => date('Y-m-d H:i:s')]);
            }
        }

        return view('applicant.outgoing_letter.index', PageLib::config([]), ['data' => $data]);
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
            $file_name = date('Y-m-d_s') . '.pdf';
            $file->move(public_path() . '/files/', $file_name);
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

        $unit = Unit::where('name', 'ilike', '%Kepegawaian%')->orWhere('name', 'ilike', '%kepegawaian%')->first();

        $admin = Admin::where('unit_id', $unit->id)->get();
        foreach ($admin as $a) {
            $userAdm = User::where('category', 'admin')->where('id', $a->user_id)->first();
            $userAdm->notify(new NewLetter('outgoing', $docs->id, $userAdm, 'outgoing'));
        }

        $super = Admin::where('role', null)->first();
        $userSup = User::where('id', $super->user_id)->first();
        $userSup->notify(new NewLetter('outgoing', $docs->id, $userSup, 'outgoing'));

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        try {
            if ($request->hasFile('uploaded_file')) {
                $file = $request->file('uploaded_file');
                $file_name = date('Y-m-d_s') . '.pdf';
                $file->move(public_path() . '/files/', $file_name);
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
                'uploaded_document' => $file_name ? $file_name : null,
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

            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
