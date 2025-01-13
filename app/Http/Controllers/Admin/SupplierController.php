<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Supplier;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $suppliers = Supplier::query();

            return DataTables::of($suppliers)
                ->addIndexColumn()
                ->addColumn('action', function ($supplier) {
                    $editUrl = route('supplier.admin.edit', Crypt::encryptString($supplier->id));
                    return '
                        <a href="javascript:void(0)" onclick="confirmDelete(' . $supplier->id . ')" class="btn btn-outline-danger btn-rounded mb-2 me-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6l-2 14H7L5 6"></path>
                                <path d="M10 11v6"></path>
                                <path d="M14 11v6"></path>
                            </svg>
                            Hapus
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

        return view('superadmin.pemasok.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.pemasok.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_supplier' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telp' => 'required|numeric',
            'email' => 'nullable|email|unique:supplier,email',
        ], [
            'nama_supplier.required' => 'Nama Supplier wajib diisi.',
            'nama_supplier.max' => 'Nama Supplier tidak boleh lebih dari 255 karakter.',
            'alamat.required' => 'Alamat Supplier wajib diisi.',
            'no_telp.required' => 'Nomor Telepon wajib diisi.',
            'no_telp.numeric' => 'Nomor Telepon harus berupa angka.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        $supplier = new Supplier();
        $supplier->nama_supplier = $request->nama_supplier;
        $supplier->alamat = $request->alamat;
        $supplier->no_telp = $request->no_telp;
        $supplier->email = $request->email;

        $supplier->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Supplier berhasil ditambahkan!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $decryptedId = Crypt::decryptString($id);
        $supplier = Supplier::findOrFail($decryptedId);

        return view('superadmin.pemasok.update', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $decryptedId = Crypt::decryptString($id);
        $validator = Validator::make($request->all(), [
            'nama_supplier' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telp' => 'required|numeric',
            'email' => 'nullable|email|unique:supplier,email,' . $decryptedId,
        ], [
            'nama_supplier.required' => 'Nama Supplier wajib diisi.',
            'nama_supplier.max' => 'Nama Supplier tidak boleh lebih dari 255 karakter.',
            'alamat.required' => 'Alamat Supplier wajib diisi.',
            'no_telp.required' => 'Nomor Telepon wajib diisi.',
            'no_telp.numeric' => 'Nomor Telepon harus berupa angka.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        $supplier = Supplier::findOrFail($decryptedId);
        $supplier->nama_supplier = $request->nama_supplier;
        $supplier->alamat = $request->alamat;
        $supplier->no_telp = $request->no_telp;
        $supplier->email = $request->email;

        $supplier->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Supplier berhasil diupdate!'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        if (!$supplier) {
            return response()->json([
                'status' => 'error',
                'message' => 'Supplier tidak ditemukan!'
            ], 404);
        }

        $supplier->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Supplier berhasil dihapus!'
        ]);
    }
}
