<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Libraries\PageLib;
use App\Models\DocumentCategory;
use DataTables;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class DocumentCategoryController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $sub_unit = DB::table('sub_units')
            ->select([
                '*',
            ])
            ->whereNull('deleted_at')->get();

        $unit = DB::table('units')
            ->select([
                '*',
            ])
            ->whereNull('deleted_at')->get();

        return view('admin.document_category.index', PageLib::config([]), ['unit' => $unit, 'sub_unit' => $sub_unit]);
    }

    public function dt()
    {
        $data = DB::table('document_categories')
            ->select([
                'document_categories.id',
                'document_categories.name',
                'document_categories.description',
                'document_categories.category',
                'document_categories.unit_id',
                'document_categories.sub_unit_id',
                'sub_units.name as sub_unit',
                'units.name as unit',
            ])->join('units', 'units.id', 'document_categories.unit_id')
            ->join('sub_units', 'sub_units.id', 'document_categories.sub_unit_id')
            ->orderBy('document_categories.created_at', 'desc')
            ->whereNull('document_categories.deleted_at');

        return DataTables::query($data)->addIndexColumn()->make(true);
    }

    public function store(Request $request)
    {
        try {
            $result = DB::transaction(function () use ($request) {
                $data = DocumentCategory::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'unit_id' => $request->unit,
                    'sub_unit_id' => $request->sub_unit,
                    'category' => $request->category,
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
        $data = DocumentCategory::select('*')->where('id', $id)->first();

        return Response::json($data);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = DocumentCategory::find($id);
            $data->update([
                'name' => $request->name ? $request->name : $data->name,
                'description' => $request->description ? $request->description : $data->description,
                'unit_id' => $request->unit ? $request->unit : $data->unit_id,
                'sub_unit_id' => $request->sub_unit ? $request->sub_unit : $data->sub_unit_id,
                'category' => $request->category ? $request->category : $data->category,
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
            $result = DocumentCategory::find($id);

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
