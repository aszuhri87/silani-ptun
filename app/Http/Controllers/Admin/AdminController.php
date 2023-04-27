<?php

namespace App\Http\Controllers\Admin;

use App\Libraries\MonthName;
use App\Libraries\PageLib;
use App\Models\Applicant;
use App\Models\Document;
use App\Models\DocumentRequirement;
use App\Models\User;
use DB;
use Illuminate\Routing\Controller as BaseController;

class AdminController extends BaseController
{
    public function index()
    {
        $data = DB::table('applicants')
        ->select('*')
        ->join('users', 'users.id', 'applicants.user_id')
        ->get();

        $accept = Document::select(
            DB::raw('COUNT(id) as count')
        )
        ->where('status', 'Diterima')->first();

        $process = Document::select(
            DB::raw('COUNT(id) as count')
        )
        ->where('status', 'Diproses')->first();

        $reject = Document::select(
            DB::raw('COUNT(id) as count')
        )
        ->where('status', 'Ditolak')->first();

        $queue = Document::select(
            DB::raw('COUNT(id) as count')
        )
        ->where('status', 'Menunggu')->first();

        $count_applicant = count($data);

        $appl = Applicant::select('id', 'user_id', DB::raw("to_char(applicants.created_at, 'TMMonth') as month_name"))
        ->groupBy('applicants.created_at', 'id');

        $chart = User::select(DB::raw('count(users.id) as count'), 'applicants.month_name')
        ->joinSub($appl, 'applicants', function ($join) {
            $join->on('users.id', 'applicants.user_id');
        })
        ->where('applicants.id', '!=', null)
        ->whereYear('users.created_at', date('Y'))
        ->groupBy(DB::raw("date_part('month',users.created_at)"), 'applicants.month_name')
        ->get();

        $doc = Document::select('id', DB::raw("to_char(documents.created_at, 'TMMonth') as month_name"))
        ->groupBy('documents.created_at', 'id');

        $count_docs = DocumentRequirement::select(DB::raw('COUNT(DISTINCT(documents.id)) as count'), 'documents.month_name')
        ->joinSub($doc, 'documents', function ($join) {
            $join->on('document_requirements.document_id', 'documents.id');
        })
        ->whereYear('document_requirements.created_at', date('Y'))
        ->groupBy(DB::raw("date_part('month',document_requirements.created_at)"), 'documents.month_name')
        ->get();

        $c_docs = MonthName::chart_data($count_docs);
        $c_data = MonthName::chart_data($chart);

        $json = json_encode($c_data, JSON_FORCE_OBJECT);

        return view('admin.dashboard.index',
        [
            'c_applicant' => $count_applicant,
            'c_docs' => $c_docs,
            'c_data' => $c_data,
            'json' => $json,
            'accept' => $accept->count,
            'reject' => $reject->count,
            'queue' => $queue->count,
        ], PageLib::config([]));
    }

    public function list_applicant()
    {
        $data = DB::table('applicants')
        ->select('*')
        ->join('users', 'users.applicant_id', 'applicants.id')
        ->get();

        return view('admin.list-applicant.index', PageLib::config([]), ['data' => $data]);
    }
}
