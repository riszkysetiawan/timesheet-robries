<?php

namespace App\Http\Controllers\Admin;

use App\Models\AreaMapping;
use App\Http\Requests\StoreAreaMappingRequest;
use App\Http\Requests\UpdateAreaMappingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class AreaMappingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function index(Request $request)
    {
        if ($request->ajax()) {
            $area = AreaMapping::select(['id', 'area']);

            return DataTables::of($area)
                ->addIndexColumn()
                ->addColumn('action', function ($area) {
                    $editUrl = route('area-mapping.admin.edit', Crypt::encryptString($area->id));
                    return '
                        <a href="javascript:void(0)" onclick="confirmDelete(' . $area->id . ')" class="btn btn-outline-danger btn-rounded mb-2 me-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6l-2 14H7L5 6"></path>
                                <path d="M10 11v6"></path>
                                <path d="M14 11v6"></path>
                            </svg>
                            Delete
                        </a>
                        <a href="' . $editUrl . '" class="btn btn-outline-primary btn-rounded mb-2 me-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                            Edit
                        </a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('superadmin.area-mapping.index');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.area-mapping.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'area' => 'required|string|max:255',
        ], [
            'area.required' => 'Kolom area wajib diisi.',
            'area.string' => 'Kolom area harus berupa teks.',
            'area.max' => 'Kolom area tidak boleh lebih dari 255 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $area = new AreaMapping();
        $area->area = $request->area;

        $area->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Area Mapping berhasil ditambahkan!'
        ]);
    }



    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $decryptedId = Crypt::decryptString($id);
        $area = AreaMapping::findOrFail($decryptedId);

        return view('superadmin.area-mapping.update', compact('area'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $decryptedId = Crypt::decryptString($id);
        $validator = Validator::make($request->all(), [
            'area' => 'required|string|max:255',
        ], [
            'area.required' => 'Kolom area wajib diisi.',
            'area.string' => 'Kolom area harus berupa teks.',
            'area.max' => 'Kolom area tidak boleh lebih dari 255 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $area = AreaMapping::findOrFail($decryptedId);
        $area->area = $request->area;
        $area->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Area Mapping berhasil diupdate!'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $area = AreaMapping::find($id);

        if (!$area) {
            return response()->json([
                'status' => 'error',
                'message' => 'Area Mapping tidak ditemukan!'
            ], 404);
        }

        $area->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Area Mapping berhasil dihapus!'
        ]);
    }
}
