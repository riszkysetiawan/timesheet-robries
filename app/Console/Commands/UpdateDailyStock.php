<?php

namespace App\Console\Commands;

use App\Models\Barang;
use App\Models\DailyStockHistory;
use App\Models\Produk;
use App\Models\StockMovement;
use Illuminate\Console\Command;

class UpdateDailyStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-daily-stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    // public function handle()
    // {
    //     //
    // }
    public function handle()
    {
        $barangs = Barang::all(); // Ambil semua barang dari tabel 'barang'
        $today = now()->startOfDay(); // Ambil waktu hari ini (awal hari)

        foreach ($barangs as $barang) {
            // Ambil data stok penutupan kemarin
            $yesterdayHistory = DailyStockHistory::where('kode_barang', $barang->kode_barang)
                ->where('rekap_date', $today->copy()->subDay()) // Sesuai nama field di database
                ->first();

            // Hitung stok pembukaan (default 0 jika tidak ada data kemarin)
            $openingStock = $yesterdayHistory ? $yesterdayHistory->ending_stock : 0;

            // Rekap data stok masuk, keluar, dan penyesuaian
            $stockIn = StockMovement::where('kode_barang', $barang->kode_barang)
                ->where('movement_type', 'in')
                ->whereDate('created_at', $today)
                ->sum('quantity');

            $stockOut = StockMovement::where('kode_barang', $barang->kode_barang)
                ->where('movement_type', 'out')
                ->whereDate('created_at', $today)
                ->sum('quantity');

            $adjustments = StockMovement::where('kode_barang', $barang->kode_barang)
                ->where('movement_type', 'adjustment')
                ->whereDate('created_at', $today)
                ->sum('quantity');

            // Hitung stok penutupan
            $closingStock = $openingStock + $stockIn - $stockOut + $adjustments;

            // Simpan data ke tabel 'daily_stock_histories'
            DailyStockHistory::updateOrCreate(
                ['kode_barang' => $barang->kode_barang, 'rekap_date' => $today],
                [
                    'total_in' => $stockIn,
                    'total_out' => $stockOut,
                    'ending_stock' => $closingStock,
                ]
            );
        }

        $this->info('Daily stock history has been updated successfully!');
    }
}
