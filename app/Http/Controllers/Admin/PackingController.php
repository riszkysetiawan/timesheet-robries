<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Packing;
use App\Http\Requests\StorePackingRequest;
use App\Http\Requests\UpdatePackingRequest;
use App\Models\Penjualan;
use App\Http\Requests\StorePenjualanRequest;
use App\Http\Requests\UpdatePenjualanRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\KategoriExport;
use App\Models\DetailPenjualan;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpKernel\Event\ViewEvent;

class PackingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $packing = Packing::with('detailPackings')->get();

            return DataTables::of($packing)
                ->addIndexColumn() // Tambahkan baris ini untuk kolom nomor urut
                ->addColumn('action', function ($packing) {
                    $editUrl = route('packing.admin.edit', Crypt::encryptString($packing->id));
                    return '
                        <a class="btn btn-outline-danger btn-rounded mb-2 me-4" href="javascript:void(0)" onclick="confirmDelete(' . $packing->id . ')" type="button">
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
                        <button class="btn btn-primary btn-sm btn-detail"
                        data-id="' . $packing->id . '"">Detail</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('superadmin.packing.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePackingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Packing $packing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Packing $packing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePackingRequest $request, Packing $packing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Packing $packing)
    {
        //
    }
}
