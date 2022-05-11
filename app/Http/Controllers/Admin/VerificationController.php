<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Document;
use App\Models\DocumentCategoryRequirement;
use App\Models\DocumentRequirement;
use App\Models\User;
use DataTables;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class VerificationController extends Controller
{
    public function index()
    {
        $docs_req_category = DocumentCategoryRequirement::select([
            'requirement_types.data_type as data_type',
            'requirement_types.description as title', 'document_category_requirements.*',
        ])
        ->leftJoin('requirement_types', 'requirement_types.requirement_type', 'document_category_requirements.requirement_type')
        ->whereNull(['document_category_requirements.deleted_at', 'requirement_types.deleted_at'])
        ->get();

        return view('admin.verification.index', ['docs_req_category' => $docs_req_category]);
    }

    public function dt()
    {
        $data = DB::table('documents')
        ->select([
            'documents.id',
            'documents.name',
            'documents.status',
            'documents.created_at as date_create',
            'document_categories.name as document_category',
            'document_categories.unit_id',
            'applicants.name as applicant',
        ])->leftJoin('applicants', 'applicants.id', 'documents.applicant_id')
        ->leftJoin('document_categories', 'document_categories.id', 'documents.document_category_id')
        ->where('documents.status', 'Diproses')
        ->whereNull('documents.deleted_at');

        $admin = Admin::where('user_id', Auth::id())->first();

        $user = User::where('id', Auth::id())->first();
        if ($user->hasRole('admin')) {
            $data->where('unit_id', $admin->unit_id);

            return DataTables::query($data)->addIndexColumn()->make(true);
        } else {
            return DataTables::query($data)->addIndexColumn()->make(true);
        }
    }

    public function store(Request $request)
    {
        try {
            $result = DB::transaction(function () use ($request) {
                $data = DocumentRequirement::create([
                        'requirement_value' => $request->requirement_value,
                        'document_id' => $request->select_docs,
                        'document_category_requirement_id' => $request->select_docs_category_req,
                ]);

                return $data;
            });

            return response([
                'data' => $result,
                'message' => 'Data Tersimpan',
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        $doc_category_req = DocumentCategoryRequirement::select([
            'requirement_types.data_type as data_type',
            'requirement_types.description as title', 'document_category_requirements.*',
        ])
        ->leftJoin('requirement_types', 'requirement_types.requirement_type', 'document_category_requirements.requirement_type')
        ->whereNull(['document_category_requirements.deleted_at', 'requirement_types.deleted_at']);

        $data = Document::select([
            'documents.id',
            'documents.name',
            'documents.status',
            'documents.created_at as date_create',
            'document_categories.name as document_category',
            'applicants.name as applicant',
            'document_category_req.requirement_type',
            'document_category_req.requirement',
            'document_category_req.required',
            'document_category_req.description',
            // 'document_requirements.requirement_value',
            'document_category_req.title',
            'document_category_req.data_type',
        ])
        ->with(['doc_req' => function ($query) {
            $query->select(['document_requirements.requirement_value', 'document_requirements.document_id', 'document_category_requirements.requirement_type'])
            ->leftJoin('document_category_requirements', 'document_category_requirements.id', 'document_requirements.document_category_requirement_id');
        },
        ])
        ->leftJoin('document_requirements', 'document_requirements.document_id', 'documents.id')
        ->leftJoin('applicants', 'applicants.id', 'documents.applicant_id')
        ->leftJoin('document_categories', 'document_categories.id', 'documents.document_category_id')
        ->leftJoinSub($doc_category_req, 'document_category_req', function ($join) {
            $join->on('document_category_req.id', 'document_requirements.document_category_requirement_id');
        })
        ->where('document_requirements.document_id', $id)
        ->whereNull('documents.deleted_at')
        ->first();

        // dd($data->doc_req);

        return Response::json($data);
    }

    public function download($id)
    {
        $data = DocumentRequirement::select([
            'id',
            'requirement_value',
        ])
        ->where('document_id', $id)
        ->whereNull('deleted_at')
        ->first();

        if (file_exists(public_path('/files/'.$data->requirement_value))) {
            return response()->download(public_path('/files/'.$data->requirement_value));
        } else {
            return redirect()->back()->with('message', 'IT WORKS!');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Document::find($id);
            $data->update([
                'status' => $request->status_edit ? $request->status_edit : $data->status,
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

    public function destroy($id)
    {
        try {
            $result = Document::find($id);

            DB::transaction(function () use ($result) {
                $result->delete();
            });

            if ($result->trashed()) {
                return response([
                    'message' => 'Successfully deleted!',
                ], 200);
            }
        } catch (Exception $e) {
            throw new Exception($e);

            return response([
                'message' => $e->getMessage(),
            ]);
        }
    }
}
