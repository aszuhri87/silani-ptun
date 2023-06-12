<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Libraries\MonthNameApplicant;
use App\Libraries\PageLib;
use App\Models\Applicant;
use App\Models\Document;
use App\Models\DocumentRequirement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $appl = Applicant::select('id')->where('user_id', Auth::id())->first();

        $accept = Document::select(
            DB::raw('COUNT(id) as count')
        )
        ->where('applicant_id', $appl->id)
        ->where('status', 'Diterima')->first();

        $process = Document::select(
            DB::raw('COUNT(id) as count')
        )
        ->where('applicant_id', $appl->id)
        ->where('status', 'Diproses')->first();

        $reject = Document::select(
            DB::raw('COUNT(id) as count')
        )
        ->where('applicant_id', $appl->id)
        ->where('status', 'Ditolak')->first();

        $queue = Document::select(
            DB::raw('COUNT(id) as count')
        )
        ->where('applicant_id', $appl->id)
        ->where('status', 'Menunggu')->first();

        $doc = Document::select('id', DB::raw("to_char(documents.created_at, 'FMMonth') as month_name"))
        ->where('applicant_id', $appl->id)
        ->whereNull('documents.deleted_at')
        ->groupBy('documents.created_at', 'id');

        $count_docs = DocumentRequirement::select(DB::raw('COUNT(DISTINCT(documents.id)) as count'), 'documents.month_name')
        ->joinSub($doc, 'documents', function ($join) {
            $join->on('document_requirements.document_id', 'documents.id');
        })
        ->whereYear('document_requirements.created_at', date('Y'))
        ->whereNull('document_requirements.deleted_at')
        ->groupBy(DB::raw("date_part('month',document_requirements.created_at)"), 'documents.month_name')
        ->get();

        $c_docs = MonthNameApplicant::chart_data($count_docs);

        return view('applicant.dashboard.index', [
            'accept' => $accept->count,
            'process' => $process->count,
            'reject' => $reject->count,
            'queue' => $queue->count,
            'c_docs' => $c_docs,
        ], PageLib::config([]));
    }
}
