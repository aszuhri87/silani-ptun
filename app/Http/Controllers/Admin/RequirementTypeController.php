<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Libraries\PageLib;
use App\Models\RequirementType;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use RealRashid\SweetAlert\Facades\Alert;

class RequirementTypeController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        return view('admin.requirement_type.index', PageLib::config([]), );
    }

    public function dt()
    {
        $data = DB::table('requirement_types')
        ->select([
            'requirement_type',
            'description',
            'data_type',
            'data_unit',
        ])
        ->whereNull('deleted_at');

        return DataTables::query($data)->addIndexColumn()->make(true);
    }

    public function store(Request $request)
    {
        $data = RequirementType::create([
                'requirement_type' => $request->requirement_type,
                'description' => $request->description,
                'data_type' => $request->data_type,
                'data_unit' => $request->data_unit,
            ]);

        Alert::success('Sukses', 'Berhasil Menambahkan Data!');

        return redirect()->back();
    }

    public function show($id)
    {
        $data = RequirementType::select('*')->where('requirement_type', $id)->first();

        return Response::json($data);
    }

    public function update(Request $request, $requirement_type)
    {
        try {
            $data = RequirementType::where('requirement_type', $requirement_type);
            $data->update([
                // 'requirement_type' => $request->requirement_type ? $request->requirement_type : $data->requirement_type,
                'description' => $request->description ? $request->description : $data->description,
                'data_type' => $request->data_type ? $request->data_type : $data->data_type,
                'data_unit' => $request->data_unit ? $request->data_unit : $data->data_unit,
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
            $result = RequirementType::find($id);

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
