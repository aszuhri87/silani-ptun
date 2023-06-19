<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Libraries\PageLib;
use App\Models\SubUnit;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use RealRashid\SweetAlert\Facades\Alert;

class SubUnitController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $data = DB::table('units')
        ->select([
         '*',
        ])
        ->whereNull('deleted_at')->get();

        return view('admin.sub_unit.index', PageLib::config([]), ['data' => $data]);
    }

    public function dt()
    {
        $data = DB::table('sub_units')
        ->select([
            'sub_units.id',
            'sub_units.name',
            'sub_units.description',
            'units.name as unit',
            'sub_units.unit_id',
        ])->leftJoin('units', 'units.id', 'sub_units.unit_id')
        ->orderBy('sub_units.created_at', 'desc')
        ->whereNull('sub_units.deleted_at');

        return DataTables::query($data)->addIndexColumn()->make(true);
    }

    public function store(Request $request)
    {
        $data = SubUnit::create([
                'name' => $request->name,
                'description' => $request->description,
                'unit_id' => $request->select_unit,
            ]);

        // return $data;

        Alert::success('Sukses', 'Berhasil Menambahkan Data!');

        return redirect()->back();
    }

    public function show($id)
    {
        $data = SubUnit::select('*')->where('id', $id)->first();

        return Response::json($data);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = SubUnit::find($id);
            $data->update([
                'name' => $request->name ? $request->name : $data->name,
                'description' => $request->description ? $request->description : $data->description,
                'unit_id' => $request->select_unit ? $request->select_unit : $data->unit_id,
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
            $result = SubUnit::find($id);

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
