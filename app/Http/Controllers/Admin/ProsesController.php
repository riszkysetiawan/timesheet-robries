<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Proses;
use App\Http\Requests\StoreProsesRequest;
use App\Http\Requests\UpdateProsesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\KategoriExport;
use Maatwebsite\Excel\Facades\Excel;

class ProsesController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $prosess = Proses::all();

            return DataTables::of($prosess)
                ->addIndexColumn() // Tambahkan baris ini untuk kolom nomor urut
                ->addColumn('action', function ($proses) {
                    $editUrl = route('proses.admin.edit', Crypt::encryptString($proses->id));
                    return '
                        <a class="btn btn-outline-danger btn-rounded mb-2 me-4" href="javascript:void(0)" onclick="confirmDelete(' . $proses->id . ')" type="button">
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
                        </a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('superadmin.proses.index');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.proses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
        ], [
            'nama.required' => 'Nama Proses wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        $proses = new Proses();
        $proses->nama = $request->nama;
        $proses->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Proses Barang berhasil ditambahkan!'
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
        $proses = Proses::findOrFail($decryptedId);

        return view('superadmin.proses.update', compact('proses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $decryptedId = Crypt::decryptString($id);
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
        ], [
            'nama.required' => 'Nama  wajib diisi.',
            'nama.string' => 'Nama  harus berupa teks.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        $proses = Proses::findOrFail($decryptedId);
        $proses->nama = $request->nama;
        $proses->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Proses berhasil diupdate!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $proses = Proses::find($id);
        if (!$proses) {
            return response()->json([
                'status' => 'error',
                'message' => 'Proses tidak ditemukan!'
            ], 404);
        }

        $proses->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Proses berhasil dihapus!'
        ]);
    }
}
