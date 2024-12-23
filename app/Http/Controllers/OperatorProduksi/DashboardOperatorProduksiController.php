<?php

namespace App\Http\Controllers\OperatorProduksi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production;
use App\Models\DetailProduction;
use App\Models\Timer;
use App\Models\Proses;
use App\Models\Produk;
use App\Models\WasteStock;
use App\Models\PurchaseOrder;
use App\Models\DetailPenjualan;
use App\Models\DetailInbound;
use App\Models\AlasanWaste;
use App\Models\Stock;
use App\Models\KategoriBarang;
use Illuminate\Support\Facades\DB;
use App\Models\Supplier;
use Carbon\Carbon;

class DashboardOperatorProduksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $total_products = Produk::count();
        $total_supplier = Supplier::count();


        return view('operator-produksi.dashboard.index', [
            'total_products' => $total_products,
            'total_supplier' => $total_supplier,
        ]);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
