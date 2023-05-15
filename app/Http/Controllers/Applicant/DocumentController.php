<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Libraries\PageLib;
use App\Models\Admin;
use App\Models\Applicant;
use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\DocumentCategoryRequirement;
use App\Models\DocumentRequirement;
use App\Models\User;
use App\Notifications\NewLetter;
use DataTables;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class DocumentController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $appl = Applicant::select('*')->where('user_id', Auth::user()->id)->first();

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
        ->whereNotNull('document_category_requirements.document_category_id')
        ->whereNull(['document_categories.deleted_at', 'document_category_requirements.deleted_at']);
        // ->get();

        if (Auth::user()->category == 'umum') {
            $docs_category->where('document_categories.category', 'umum');
        } else {
            $docs_category->where('document_categories.category', 'karyawan');
        }

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
            'docs_category' => $docs_category->get(),
            'req_type' => $req_type,
            'docs_req_category' => $docs_req_category,
        ], PageLib::config([]));
    }

    public function dt()
    {
        $appl = Applicant::select('*')->where('user_id', Auth::user()->id)->first();

        $data = DB::table('documents')
        ->select([
            'documents.id',
            'documents.name',
            'documents.status',
            'users.name as chief_name',
             DB::raw("to_char(documents.created_at , 'dd TMMonth YYYY, HH24:mi' ) as date_create"),
            'document_categories.name as document_category',
        ])->leftJoin('applicants', 'applicants.id', 'documents.applicant_id')
        ->leftJoin('document_categories', 'document_categories.id', 'documents.document_category_id')
        ->leftJoin('users', 'users.id', 'documents.user_id')
        ->where('documents.status', 'Menunggu')
        ->where('documents.applicant_id', $appl->id)
        ->whereNull('documents.deleted_at')
        ->orderBy('documents.created_at', 'DESC');

        return DataTables::query($data)->addIndexColumn()->make(true);
    }

    public function store(Request $request)
    {
        try {
            $result = DB::transaction(function () use ($request) {
                $appl = Applicant::select('*')->where('user_id', Auth::user()->id)->first();

                $document = Document::create([
                    'name' => $request->name,
                    'applicant_id' => $appl->id,
                    'status' => 'Menunggu',
                    'document_category_id' => $request->id_cat,
                    'user_id' => $request->chief,
                    ]);

                $category_req = DocumentCategoryRequirement::select('*')
                    ->where('document_category_id', $request->id_cat)
                    ->get();

                if (is_array($request->requirement_value) && count($request->requirement_value) > 0) {
                    for ($index = 0; $index < count($request->requirement_value); ++$index) {
                        $value = [];
                        if ($request->hasFile('requirement_value.'.$index)) {
                            $file = $request->file('requirement_value.'.$index);
                            $name = date('Y-m-d_s').'_'.$file->getClientOriginalName();
                            $file->move(public_path().'/files/', $name);

                            $value[$index] = $name;
                        } else {
                            $value[$index] = $request->requirement_value[$index];
                        }

                        $data = DocumentRequirement::create([
                            'requirement_value' => $value[$index],
                            'document_id' => $document->id,
                            'document_category_requirement_id' => $category_req[$index]->id,
                        ]);

                        $data['document_category_id'] = $document->document_category_id;
                    }

                    return $data;
                }
            });

            $doc_category = DocumentCategory::where('id', $result->document_category_id)->first();

            $admin = Admin::where('unit_id', $doc_category->unit_id)->get();

            foreach ($admin as $a) {
                $user = User::where('id', $a->user_id)->first();
                $user->notify(new NewLetter('inbox', $result->document_id, $user, 'inbox'));
            }

            $super = Admin::where('unit_id', null)->first();
            $superuser = User::where('id', $super->user_id)->first();
            $superuser->notify(new NewLetter('inbox', $result->document_id, $superuser, 'inbox'));

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
            'requirement_types.requirement_type as title',
            'document_category_requirements.*',
        ])
        ->leftJoin('requirement_types', 'requirement_types.requirement_type', 'document_category_requirements.requirement_type')
        ->whereNull(['document_category_requirements.deleted_at', 'requirement_types.deleted_at']);

        $data = Document::select([
            'documents.id',
            'documents.name',
            'documents.status',
            'users.name as receiver_name',
             DB::raw("to_char(documents.created_at , 'dd TMMonth YYYY, HH24:mi' ) as date_create"),
            'document_categories.name as document_category',
            'applicants.name as applicant',
            'document_category_req.requirement_type',
            'document_category_req.requirement',
            'document_category_req.required',
            'document_category_req.description',
            'document_category_req.title',
            'document_category_req.data_type',
            'users.name as chief_name',
        ])
        ->with(['doc_req' => function ($query) {
            $query->select(['document_requirements.id', 'document_requirements.requirement_value', 'document_requirements.document_id', 'document_category_requirements.data_min',
            'document_category_requirements.data_max', 'document_category_requirements.requirement_type', 'requirement_types.data_type as data_type',
            'requirement_types.requirement_type as title', ])
            ->leftJoin('document_category_requirements', 'document_category_requirements.id', 'document_requirements.document_category_requirement_id')
            ->leftJoin('requirement_types', 'requirement_types.requirement_type', 'document_category_requirements.requirement_type')
            ->whereNull(['document_category_requirements.deleted_at', 'requirement_types.deleted_at']);
        },
        ])
        ->leftJoin('document_requirements', 'document_requirements.document_id', 'documents.id')
        ->leftJoin('applicants', 'applicants.id', 'documents.applicant_id')
        ->leftJoin('document_categories', 'document_categories.id', 'documents.document_category_id')
        ->leftJoin('users', 'users.id', 'documents.user_id')
        ->leftJoinSub($doc_category_req, 'document_category_req', function ($join) {
            $join->on('document_category_req.id', 'document_requirements.document_category_requirement_id');
        })
        ->where('document_requirements.document_id', $id)
        ->whereNull('documents.deleted_at')
        ->first();

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
            'requirement_types.requirement_type as title',
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

        return response()->download(public_path('/files/'.$data->requirement_value));
    }

    public function update(Request $request, $id)
    {
        try {
            $result = DB::transaction(function () use ($request,$id) {
                $appl = Applicant::select('*')->where('user_id', Auth::user()->id)->first();

                $document = Document::find($id);
                $document->update([
                    'name' => $request->name,
                    'user_id' => $request->chief,
                ]);

                $data = DocumentRequirement::where('document_id', $id)->get();

                $file_doc = null;

                if (is_array($request->requirement_value) && count($request->requirement_value) > 0) {
                    for ($index = 0; $index < count($request->requirement_value); ++$index) {
                        $value = [];
                        if ($request->hasFile('requirement_value.'.$index)) {
                            $file = $request->file('requirement_value.'.$index);
                            $name = date('Y-m-d_s').'_'.$file->getClientOriginalName();
                            $file->move(public_path().'/files/', $name);

                            $value[$index] = $name;
                        } else {
                            $value[$index] = $request->requirement_value[$index];
                        }
                        $file_doc = DocumentRequirement::whereIn('document_category_requirement_id', [$data[$index]->document_category_requirement_id])->update([
                                'requirement_value' => $value[$index] ? $value[$index] : $data[$index]->requirement_value,
                            ]);
                    }
                }

                return $file_doc;
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
