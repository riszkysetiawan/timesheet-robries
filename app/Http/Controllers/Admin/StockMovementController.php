<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\StockMovement;
use App\Http\Requests\StoreStockMovementRequest;
use App\Http\Requests\UpdateStockMovementRequest;
use App\Exports\InboundExport;
use App\Models\Barang;
use App\Models\CompanyProfile;
use App\Models\DetailInbond;
use App\Models\Supplier;
use App\Models\ProfileCompany;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\SatuanBarang;
use Illuminate\Support\Facades\Crypt;
use App\Models\PurchaseOrder;
use App\Models\Stock;
use App\Models\DetailInbound;
use Illuminate\Support\Facades\Log;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;

class StockMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $movements = StockMovement::with('barang'); // Relasi dengan tabel barang jika diperlukan

            // Memeriksa apakah ada parameter start_date dan end_date
            if ($request->has('start_date') && $request->has('end_date')) {
                $startDate = $request->input('start_date');
                $endDate = $request->input('end_date');

                // Filter berdasarkan rentang tanggal
                $movements = $movements->whereBetween('created_at', [$startDate, $endDate]);
            }

            return DataTables::of($movements)
                ->addIndexColumn()
                ->addColumn('kode_barang', function ($movement) {
                    return $movement->kode_barang;
                })
                ->addColumn('movement_type', function ($movement) {
                    return ucfirst($movement->movement_type); // Menampilkan movement type dengan kapitalisasi pertama
                })
                ->addColumn('quantity', function ($movement) {
                    return $movement->quantity;
                })
                ->addColumn('created_at', function ($movement) {
                    return $movement->created_at->format('Y-m-d H:i:s'); // Format tanggal
                })
                ->addColumn('action', function ($movement) {
                    $deleteUrl = route('stock-movement.admin.destroy', Crypt::encryptString($movement->id));
                    return '
                        <a class="btn btn-outline-danger btn-rounded mb-2 me-4" href="javascript:void(0)" onclick="confirmDelete(' . $movement->id . ')" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6l-2 14H7L5 6"></path>
                                <path d="M10 11v6"></path>
                                <path d="M14 11v6"></path>
                            </svg>
                            Delete
                        </a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('superadmin.movement.index');
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
    public function store(StoreStockMovementRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(StockMovement $stockMovement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockMovement $stockMovement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStockMovementRequest $request, StockMovement $stockMovement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockMovement $stockMovement)
    {
        //
    }
}
