<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Document;
use App\Models\DocumentCategoryRequirement;
use App\Models\DocumentRequirement;
use DataTables;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class DocumentController extends Controller
{
    public function index()
    {
        $docs_category = DB::table('document_categories')
        ->select([
         'document_category_requirements.id',
         'document_category_requirements.document_category_id',
         'document_category_requirements.requirement_type',
         'document_category_requirements.requirement',
         'document_category_requirements.required',
         'document_category_requirements.data_min',
         'document_category_requirements.data_max',
         'document_categories.name',
         'document_categories.description',
        ])
        ->leftJoin('document_category_requirements', 'document_category_requirements.document_category_id', 'document_categories.id')
        ->distinct('document_categories.name')
        ->whereNull(['document_categories.deleted_at', 'document_category_requirements.deleted_at'])
        ->get();

        $docs_req_category = DB::table('document_category_requirements')
        ->select([
            'document_category_requirements.id',
            'document_category_requirements.requirement',
            'document_category_requirements.required',
            'document_category_requirements.data_min',
            'document_category_requirements.data_max',
            'document_category_requirements.description',
            'document_category_requirements.document_category_id',
            'document_categories.name as document_category',
            'requirement_types.requirement_type as requirement_type',
            'requirement_types.data_type as data_type',
        ])->leftJoin('document_categories', 'document_categories.id', 'document_category_requirements.document_category_id')
        ->leftJoin('requirement_types', 'requirement_types.requirement_type', 'document_category_requirements.requirement_type')
        ->whereNull('document_category_requirements.deleted_at')
        ->get();

        $req_type = DB::table('requirement_types')
        ->select([
         '*',
        ])
        ->whereNull('deleted_at')->get();

        $doc_category_req = DocumentCategoryRequirement::select([
            '*',
        ])->whereNull('deleted_at');

        return view('applicant.document.index',
        [
            'docs_category' => $docs_category,
            'req_type' => $req_type,
            'docs_req_category' => $docs_req_category,
        ]);
    }

    public function dt()
    {
        $appl = Applicant::select('*')->where('user_id', Auth::user()->id)->first();

        $data = DB::table('documents')
        ->select([
            'documents.id',
            'documents.name',
            'documents.status',
            'documents.created_at as date_create',
            'document_categories.name as document_category',
        ])->leftJoin('applicants', 'applicants.id', 'documents.applicant_id')
        ->leftJoin('document_categories', 'document_categories.id', 'documents.document_category_id')
        ->where('documents.status', 'Menunggu')
        ->where('documents.applicant_id', $appl->id)
        ->whereNull('documents.deleted_at');

        return DataTables::query($data)->addIndexColumn()->make(true);
    }

    public function store(Request $request)
    {
        // for ($index = 0; $index < 10; ++$index) {
        //     dd($request->file('requirement_value.'.$index));
        // }
        try {
            $result = DB::transaction(function () use ($request) {
                // $count = count($request->requirement_value);
                $appl = Applicant::select('*')->where('user_id', Auth::user()->id)->first();

                $document = Document::create([
                    'name' => $request->name,
                    'applicant_id' => $appl->id,
                    'status' => 'Menunggu',
                    'document_category_id' => $request->id_cat,
                    ]);

                $category_req = DocumentCategoryRequirement::select('*')
                    ->where('document_category_id', $request->id_cat)
                    ->get();

                if (is_array($request->requirement_value) && count($request->requirement_value) > 0) {
                    for ($index = 0; $index < count($request->requirement_value); ++$index) {
                        // dd($request->file('requirement_value.'.$index));
                        $value = [];
                        if ($request->hasFile('requirement_value.'.$index)) {
                            $file = $request->file('requirement_value.'.$index);
                            $name = $file->getClientOriginalName();
                            $file->move(public_path().'/files/', $name);

                            $value[$index] = $name;
                        // $path[] = $request->file('requirement_value')->store('public/files');
                        } else {
                            $value[$index] = $request->requirement_value[$index];
                        }

                        $data = DocumentRequirement::create([
                            'requirement_value' => $value[$index],
                            'document_id' => $document->id,
                            'document_category_requirement_id' => $category_req[$index]->id,
                        ]);
                    }

                    return $data;
                }
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
            'document_requirements.requirement_value',
            'document_category_req.title',
            'document_category_req.data_type',
        ])

        ->leftJoin('document_requirements', 'document_requirements.document_id', 'documents.id')
        ->leftJoin('applicants', 'applicants.id', 'documents.applicant_id')
        ->leftJoin('document_categories', 'document_categories.id', 'documents.document_category_id')
        ->leftJoinSub($doc_category_req, 'document_category_req', function ($join) {
            $join->on('document_category_req.id', 'document_requirements.document_category_requirement_id');
        })
        ->where('document_requirements.document_id', $id)
        ->whereNull('documents.deleted_at')
        ->get();

        // dd($data);

        return Response::json($data);
    }

    public function get_category($id)
    {
        $data = DB::table('document_category_requirements')
        ->select([
            'document_category_requirements.id',
            'document_category_requirements.requirement',
            'document_category_requirements.required',
            'document_category_requirements.data_min',
            'document_category_requirements.data_max',
            'document_category_requirements.description',
            'document_category_requirements.document_category_id',
            'document_categories.name as document_category',
            'requirement_types.requirement_type as requirement_type',
            'requirement_types.data_type as data_type',
            'requirement_types.description as title',
        ])->leftJoin('document_categories', 'document_categories.id', 'document_category_requirements.document_category_id')
        ->leftJoin('requirement_types', 'requirement_types.requirement_type', 'document_category_requirements.requirement_type')
        ->where('document_category_requirements.document_category_id', $id)
        ->whereNull('document_category_requirements.deleted_at')
        ->get();

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

        // dd($data);

        return response()->download(public_path('/files/'.$data->requirement_value));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        try {
            $result = DB::transaction(function () use ($request,$id) {
                // $count = count($request->requirement_value);
                $appl = Applicant::select('*')->where('user_id', Auth::user()->id)->first();

                $document = Document::find($id);
                $document->update([
                    'name' => $request->name,
                ]);

                $data = DocumentRequirement::where('document_id', $id);
                if (is_array($request->requirement_value) && count($request->requirement_value) > 0) {
                    for ($index = 0; $index < count($request->requirement_value); ++$index) {
                        // dd($request->file('requirement_value.'.$index));
                        $value = [];
                        if ($request->hasFile('requirement_value.'.$index)) {
                            $file = $request->file('requirement_value.'.$index);
                            $name = $file->getClientOriginalName();
                            $file->move(public_path().'/files/', $name);

                            $value[$index] = $name;
                        // $path[] = $request->file('requirement_value')->store('public/files');
                        } else {
                            $value[$index] = $request->requirement_value[$index];
                        }

                        $data->update([
                            'requirement_value' => $value[$index],
                            'document_id' => $document->id,
                            // 'document_category_requirement_id' => $category_req[$index]->id,
                        ]);
                    }

                    return $data;
                }
            });

            return response([
                'data' => $result,
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

            DB::transaction(function () use ($result,$id) {
                $file = DocumentRequirement::where('document_id', $id)->get();
                foreach ($file as $f) {
                    $destinationPath[] = public_path().'/files/'.$f->requirement_value;
                    File::delete($destinationPath);
                }

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
