<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Size;
use App\Http\Requests\UpdateSizeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Encryption\DecryptException;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use App\Exports\SizeExport;
use App\Imports\SizeImport;
use App\Models\Produk;
use Yajra\DataTables\Facades\DataTables;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function downloadExcel()
    {
        return Excel::download(new SizeExport, 'size.xlsx');
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sizes = Size::all();

            return DataTables::of($sizes)
                ->addIndexColumn() // Tambahkan baris ini untuk kolom nomor urut
                ->addColumn('action', function ($size) {
                    $editUrl = route('size-produk.admin.edit', Crypt::encryptString($size->id));
                    return '
                        <a class="btn btn-outline-danger btn-rounded mb-2 me-4" href="javascript:void(0)" onclick="confirmDelete(' . $size->id . ')" type="button">
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

        return view('superadmin.size.index');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.size.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'size' => 'required|string|max:255',
        ], [
            'size.required' => 'Size wajib diisi.',
            'size.string' => 'Size harus berupa teks.',
            'size.max' => 'Size tidak boleh lebih dari 255 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        $size = new Size();
        $size->size = $request->size;
        $size->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Size Barang berhasil ditambahkan!'
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
        $size = Size::findOrFail($decryptedId);

        return view('superadmin.size.update', compact('size'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $decryptedId = Crypt::decryptString($id);
        $validator = Validator::make($request->all(), [
            'size' => 'required|string|max:255',
        ], [
            'size.required' => 'Nama size wajib diisi.',
            'size.string' => 'Nama size harus berupa teks.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        $size = Size::findOrFail($decryptedId);
        $size->size = $request->size;
        $size->save();

        return response()->json([
            'status' => 'success',
            'message' => 'size berhasil diupdate!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $size = Size::find($id);
        if (!$size) {
            return response()->json([
                'status' => 'error',
                'message' => 'size tidak ditemukan!'
            ], 404);
        }

        $size->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'size berhasil dihapus!'
        ]);
    }
}
