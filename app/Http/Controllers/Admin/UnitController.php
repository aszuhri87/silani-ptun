<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Libraries\PageLib;
use App\Models\Unit;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use RealRashid\SweetAlert\Facades\Alert;

class UnitController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        return view('admin.unit.index', PageLib::config([]), );
    }

    public function dt()
    {
        $data = DB::table('units')
        ->select([
            'id',
            'name',
            'description',
        ])
        ->orderBy('units.created_at', 'desc')
        ->whereNull('deleted_at');

        return DataTables::query($data)->addIndexColumn()->make(true);
    }

    public function store(Request $request)
    {
        $data = Unit::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);

        // return $data;

        Alert::success('Sukses', 'Berhasil Menambahkan Data!');

        return redirect()->back();
    }

    public function show($id)
    {
        $data = Unit::select('*')->where('id', $id)->first();

        return Response::json($data);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Unit::find($id);
            $data->update([
                'name' => $request->name ? $request->name : $data->name,
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
            $result = Unit::find($id);

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

    public function find_unit(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $letters = DB::table('units')
        ->select([
            'units.id',
            'units.name',
            ])
        ->where('units.name', 'ilike', '%'.$term.'%')
        ->whereNull('units.deleted_at')
        ->get();

        $formatted_tags = [];

        foreach ($letters as $letter) {
            $formatted_tags[] = ['id' => $letter->id, 'text' => $letter->name];
        }

        return \Response::json($formatted_tags);
    }
}
