<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentRequirement;
use DataTables;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class DocumentRequirementController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $docs = DB::table('documents')
        ->select([
         '*',
        ])
        ->whereNull('deleted_at')->get();

        $docs_category_req = DB::table('document_category_requirements')
        ->select([
         '*',
        ])
        ->whereNull('deleted_at')->get();

        return view('admin.document_req.index', ['docs' => $docs, 'docs_category_req' => $docs_category_req]);
    }

    public function dt()
    {
        $data = DB::table('document_requirements')
        ->select([
            'document_requirements.id',
            'document_requirements.requirement_value',
            'documents.name as document',
            'document_category_requirements.requirement as document_category_requirement',
        ])->leftJoin('documents', 'documents.id', 'document_requirements.document_id')
        ->leftJoin('document_category_requirements', 'document_category_requirements.id', 'document_requirements.document_category_requirement_id')
        ->whereNull('document_requirements.deleted_at');

        return DataTables::query($data)->addIndexColumn()->make(true);
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
        $data = DocumentRequirement::select('*')->where('id', $id)->first();

        return Response::json($data);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = DocumentRequirement::find($id);
            $data->update([
                'requirement_value' => $request->requirement_value ? $request->requirement_value : $data->requirement_value,
                'document_id' => $request->select_docs ? $request->select_docs : $data->select_docs,
                'document_category_requirement_id' => $request->select_docs_category_req ? $request->select_docs_category_req : $data->select_docs_category_req,
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
            $result = DocumentRequirement::find($id);

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
