<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\DailyStockHistory;
use App\Http\Requests\StoreDailyStockHistoryRequest;
use App\Http\Requests\UpdateDailyStockHistoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\HistoryStockExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class DailyStockHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Ambil parameter start_date dan end_date jika ada
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            $histories = DailyStockHistory::with('barang') // Relasi dengan tabel barang, jika diperlukan
                ->select('daily_stock_histories.*');

            // Filter berdasarkan rentang tanggal jika ada
            if ($startDate && $endDate) {
                $histories->whereBetween('rekap_date', [$startDate, $endDate]);
            }

            return DataTables::of($histories)
                ->addIndexColumn() // Tambahkan kolom nomor urut
                ->addColumn('kode_barang', function ($history) {
                    return $history->kode_barang;
                })
                ->addColumn('rekap_date', function ($history) {
                    return $history->rekap_date;
                })
                ->addColumn('total_in', function ($history) {
                    return $history->total_in;
                })
                ->addColumn('total_out', function ($history) {
                    return $history->total_out;
                })
                ->addColumn('ending_stock', function ($history) {
                    return $history->ending_stock;
                })
                ->addColumn('action', function ($history) {
                    $deleteUrl = route('history.stock.destroy', Crypt::encryptString($history->id));
                    return '
                        <a class="btn btn-outline-danger btn-rounded mb-2 me-4" href="javascript:void(0)" onclick="confirmDelete(' . $history->id . ')" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6l-2 14H7L5 6"></path>
                                <path d="M10 11v6"></path>
                                <path d="M14 11v6"></path>
                            </svg>
                            Delete
                        </a>';
                })
                ->rawColumns(['action']) // Render kolom action sebagai HTML
                ->make(true);
        }

        return view('superadmin.history-stock.index');
    }
    public function downloadExcel(Request $request)
    {
        \Log::info("Request Parameters: ", $request->all());

        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');

        if ($startDate && $endDate) {
            try {
                $startDate = Carbon::parse($startDate)->startOfDay();
                $endDate = Carbon::parse($endDate)->endOfDay();
            } catch (\Exception $e) {
                alert()->error('Tanggal tidak valid.', 'Error');
                return redirect()->back();
            }
        } else {
            $startDate = null;
            $endDate = null;
        }

        // Ambil data berdasarkan filter tanggal
        $data = DailyStockHistory::query()
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('rekap_date', [$startDate, $endDate]);
            })
            ->get();

        // Jika data kosong, tampilkan pesan SweetAlert
        if ($data->isEmpty()) {
            alert()->error('Tidak ada data untuk rentang tanggal yang dipilih.', 'Tidak Ada Data');
            return redirect()->back();
        }

        // Panggil export dengan parameter tanggal jika data ditemukan
        return Excel::download(new HistoryStockExport($startDate, $endDate), 'history_stock.xlsx');
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
    public function store(StoreDailyStockHistoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DailyStockHistory $dailyStockHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DailyStockHistory $dailyStockHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDailyStockHistoryRequest $request, DailyStockHistory $dailyStockHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DailyStockHistory $dailyStockHistory)
    {
        //
    }
}
