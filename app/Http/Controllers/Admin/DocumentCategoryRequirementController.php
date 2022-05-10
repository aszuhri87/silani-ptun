<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentCategoryRequirement;
use DataTables;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class DocumentCategoryRequirementController extends Controller
{
    public function index()
    {
        $docs_category = DB::table('document_categories')
        ->select([
         '*',
        ])
        ->whereNull('deleted_at')->get();

        $req_type = DB::table('requirement_types')
        ->select([
         '*',
        ])
        ->whereNull('deleted_at')->get();

        return view('admin.document_category_req.index', ['docs_category' => $docs_category, 'req_type' => $req_type]);
    }

    public function dt()
    {
        $data = DB::table('document_category_requirements')
        ->select([
            'document_category_requirements.id',
            'document_category_requirements.requirement',
            'document_category_requirements.required',
            'document_category_requirements.data_min',
            'document_category_requirements.data_max',
            'document_category_requirements.description',
            'document_categories.name as document_category',
            'requirement_types.requirement_type as requirement_type',
        ])->leftJoin('document_categories', 'document_categories.id', 'document_category_requirements.document_category_id')
        ->leftJoin('requirement_types', 'requirement_types.requirement_type', 'document_category_requirements.requirement_type')
        ->whereNull('document_category_requirements.deleted_at');

        return DataTables::query($data)->addIndexColumn()->make(true);
    }

    public function store(Request $request)
    {
        try {
            $result = DB::transaction(function () use ($request) {
                $data = DocumentCategoryRequirement::create([
                        'document_category_id' => $request->select_docs_category,
                        'requirement_type' => $request->select_req_type,
                        'requirement' => $request->requirement,
                        'required' => $request->required,
                        'data_min' => $request->data_min,
                        'data_max' => $request->data_max,
                        'description' => $request->description,
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
        $data = DocumentCategoryRequirement::select('*')->where('id', $id)->first();

        return Response::json($data);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = DocumentCategoryRequirement::find($id);
            $data->update([
                'document_category_id' => $request->select_docs_category ? $request->select_docs_category : $data->document_category_id,
                'requirement_type' => $request->select_req_type ? $request->select_req_type : $data->requirement_type,
                'requirement' => $request->requirement ? $request->requirement : $data->requirement,
                'required' => $request->required ? $request->required : $data->required,
                'data_min' => $request->data_min ? $request->data_min : $data->data_min,
                'data_max' => $request->data_max ? $request->data_max : $data->data_max,
                'description' => $request->description ? $request->description : $data->description,
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
            $result = DocumentCategoryRequirement::find($id);

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
