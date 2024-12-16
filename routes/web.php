<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\WarnaController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\ProductionController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\StockController;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Admin\ProsesController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\VendorPengirimanController;
use App\Http\Controllers\Admin\MappingController;
use App\Http\Controllers\Admin\AreaMappingController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
})->name('index.login');
Route::post('/login-ajax', [AuthController::class, 'login'])->name('login.ajax');

Route::middleware(['role:Superadmin'])->group(function () {
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard.superadmin');
    // user superadmin start
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/tambah/user/admin', [UserController::class, 'create'])->name('users.create');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::delete('/delete/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::get('/edit/user/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/update/user/{id}', [UserController::class, 'update'])->name('user.update');
    // user end
    // Profile
    Route::get('/profile/superadmin', [AuthController::class, 'index'])->name('profile.superadmin');
    Route::post('/profile/superadmin/update', [AuthController::class, 'update'])->name('profile-superadmin.update');
    Route::get('/logout/superadmin', [AuthController::class, 'logout'])->name('logout.superadmin');
    //  end profile
    // kategori barang
    Route::get('/warna/admin', [WarnaController::class, 'index'])->name('warna.admin.index');
    Route::get('/tambah/warna/admin', [WarnaController::class, 'create'])->name('warna.admin.create');
    Route::post('/simpan/warna/admin/store', [WarnaController::class, 'store'])->name('warna.admin.store');
    Route::delete('/delete/warna/admin/{id}', [WarnaController::class, 'destroy'])->name('warna.admin.destroy');
    Route::get('/edit/warna/admin/{id}', [WarnaController::class, 'edit'])->name('warna.admin.edit');
    Route::post('/update/warna/admin/{id}', [WarnaController::class, 'update'])->name('warna.admin.update');
    Route::get('/warna/download-excel/admin', [WarnaController::class, 'downloadExcel'])->name('warna.download.excel.admin');
    //  end kategori barang
    // proses
    Route::get('/proses/admin', [ProsesController::class, 'index'])->name('proses.admin.index');
    Route::get('/tambah/proses/admin', [ProsesController::class, 'create'])->name('proses.admin.create');
    Route::post('/simpan/proses/admin/store', [ProsesController::class, 'store'])->name('proses.admin.store');
    Route::delete('/delete/proses/admin/{id}', [ProsesController::class, 'destroy'])->name('proses.admin.destroy');
    Route::get('/edit/proses/admin/{id}', [ProsesController::class, 'edit'])->name('proses.admin.edit');
    Route::post('/update/proses/admin/{id}', [ProsesController::class, 'update'])->name('proses.admin.update');
    // end proses
    // kategori barang
    Route::get('/kategori/admin', [KategoriController::class, 'index'])->name('kategori.admin.index');
    Route::get('/tambah/kategori/admin', [KategoriController::class, 'create'])->name('kategori.admin.create');
    Route::post('/simpan/kategori/admin/store', [KategoriController::class, 'store'])->name('kategori.admin.store');
    Route::delete('/delete/kategori/admin/{id}', [KategoriController::class, 'destroy'])->name('kategori.admin.destroy');
    Route::get('/edit/kategori/admin/{id}', [KategoriController::class, 'edit'])->name('kategori.admin.edit');
    Route::post('/update/kategori/admin/{id}', [KategoriController::class, 'update'])->name('kategori.admin.update');
    Route::get('/kategori/download-excel/admin', [KategoriController::class, 'downloadExcel'])->name('kategori.download.excel.admin');
    //  end kategori barang
    // role
    Route::get('/role/admin', [RoleController::class, 'index'])->name('role.admin.index');
    Route::get('/tambah/role/admin', [RoleController::class, 'create'])->name('role.admin.create');
    Route::post('/simpan/role/admin/store', [RoleController::class, 'store'])->name('role.admin.store');
    Route::delete('/delete/role/admin/{id}', [RoleController::class, 'destroy'])->name('role.admin.destroy');
    Route::get('/edit/role/admin/{id}', [RoleController::class, 'edit'])->name('role.admin.edit');
    Route::post('/update/role/admin/{id}', [RoleController::class, 'update'])->name('role.admin.update');
    // end role
    // vendor pengiriman
    Route::get('/vendor-pengiriman/admin', [VendorPengirimanController::class, 'index'])->name('vendor-pengiriman.admin.index');
    Route::get('/tambah/vendor-pengiriman/admin', [VendorPengirimanController::class, 'create'])->name('vendor-pengiriman.admin.create');
    Route::post('/simpan/vendor-pengiriman/admin/store', [VendorPengirimanController::class, 'store'])->name('vendor-pengiriman.admin.store');
    Route::delete('/delete/vendor-pengiriman/admin/{id}', [VendorPengirimanController::class, 'destroy'])->name('vendor-pengiriman.admin.destroy');
    Route::get('/edit/vendor-pengiriman/admin/{id}', [VendorPengirimanController::class, 'edit'])->name('vendor-pengiriman.admin.edit');
    Route::post('/update/vendor-pengiriman/admin/{id}', [VendorPengirimanController::class, 'update'])->name('vendor-pengiriman.admin.update');
    // end vendor penngiriman
    // area mapping
    Route::get('/area-mapping/admin', [AreaMappingController::class, 'index'])->name('area-mapping.admin.index');
    Route::get('/tambah/area-mapping/admin', [AreaMappingController::class, 'create'])->name('area-mapping.admin.create');
    Route::post('/simpan/area-mapping/admin/store', [AreaMappingController::class, 'store'])->name('area-mapping.admin.store');
    Route::delete('/delete/area-mapping/admin/{id}', [AreaMappingController::class, 'destroy'])->name('area-mapping.admin.destroy');
    Route::get('/edit/area-mapping/admin/{id}', [AreaMappingController::class, 'edit'])->name('area-mapping.admin.edit');
    Route::post('/update/area-mapping/admin/{id}', [AreaMappingController::class, 'update'])->name('area-mapping.admin.update');
    // end area mapping
    // mapping area
    Route::get('/mapping/admin', [MappingController::class, 'index'])->name('mapping.admin.index');
    Route::get('/tambah/mapping/admin', [MappingController::class, 'create'])->name('mapping.admin.create');
    Route::post('/simpan/mapping/admin/store', [MappingController::class, 'store'])->name('mapping.admin.store');
    Route::delete('/delete/mapping/admin/{id}', [MappingController::class, 'destroy'])->name('mapping.admin.destroy');
    Route::get('/edit/mapping/admin/{id}', [MappingController::class, 'edit'])->name('mapping.admin.edit');
    Route::post('/update/mapping/admin/{id}', [MappingController::class, 'update'])->name('mapping.admin.update');
    // end mapping area
    // produk
    Route::get('/produk/admin', [ProdukController::class, 'index'])->name('produk.admin.index');
    Route::get('/tambah/produk/admin', [ProdukController::class, 'create'])->name('produk.admin.create');
    Route::post('/simpan/produk/admin/store', [ProdukController::class, 'store'])->name('produk.admin.store');
    Route::delete('/delete/produk/admin/{id}', [ProdukController::class, 'destroy'])->name('produk.admin.destroy');
    Route::get('/edit/produk/admin/{id}', [ProdukController::class, 'edit'])->name('produk.admin.edit');
    Route::post('/update/produk/admin/{id}', [ProdukController::class, 'update'])->name('produk.admin.update');
    Route::get('/produk/download-excel/admin', [ProdukController::class, 'downloadExcel'])->name('produk.download.excel.admin');
    Route::get('/upload/files/produk/admin', [ProdukController::class, 'uploadFile'])->name('upload.produk.files.admin');
    Route::get('/download-template/produk/admin', function () {
        $file = storage_path('app/public/barcode.xlsx');
        return Response::download($file, 'barcode.xlsx');
    })->name('download.template.upload.produk.admin');
    Route::post('/upload-produk-excel/admin', [ProdukController::class, 'uploadExcel'])->name('upload.produk.admin');
    //  end produk
    // production
    Route::get('/production/admin', [ProductionController::class, 'index'])->name('production.admin.index');
    Route::get('/tambah/production/admin', [ProductionController::class, 'create'])->name('production.admin.create');
    Route::post('/simpan/production/admin/store', [ProductionController::class, 'store'])->name('production.admin.store');
    Route::delete('/delete/production/admin/{id}', [ProductionController::class, 'destroy'])->name('production.admin.destroy');
    Route::get('/edit/production/admin/{id}', [ProductionController::class, 'edit'])->name('production.admin.edit');
    Route::get('/edit-timer/production/admin/{id}', [ProductionController::class, 'editTimer'])->name('production.admin.edit.timer');
    Route::post('/production/update-timer', [ProductionController::class, 'updateTimer'])->name('admin.production.updateTimer');
    Route::post('/admin/production/delete-timer', [ProductionController::class, 'deleteTimer'])->name('admin.production.deleteTimer');
    Route::get('/mulai-timer/production/admin/{id}', [ProductionController::class, 'timer'])->name('timer-start.production.admin');
    Route::get('/production/admin/timerbarcode/{barcode}', [ProductionController::class, 'timerbarcode'])->name('production.admin.timerbarcode');
    Route::post('/production/start-timer', [ProductionController::class, 'startTimer'])->name('production.startTimer');
    Route::post('/update/production/admin/{id}', [ProductionController::class, 'update'])->name('production.admin.update');
    Route::get('/production/download-excel/admin', [ProductionController::class, 'downloadExcel'])->name('production.download.excel.admin');
    Route::get('/penjualan/{id}/preview/admin', [ProductionController::class, 'preview'])->name('purchase-order.preview');
    Route::get('/show/production/admin/{id}', [ProductionController::class, 'show'])->name('detail.production.admin');
    Route::get('/get-produk/admin/{so_number}', [ProductionController::class, 'getProduk'])->name('get.produk.admin');
    Route::get('/get-produk/admin',  [ProductionController::class, 'getAllProduk'])->name('get.all-produk-admin');
    Route::get('/get-ukuran/admin',  [ProductionController::class, 'getAllUkuran'])->name('get.all-ukuran-admin');
    Route::get('/get-warna/admin', [ProductionController::class, 'getWarna'])->name('get.all-warna.produk-admin');
    // end production
    // Stock
    Route::get('/stock/produk/admin', [StockController::class, 'index'])->name('stock-produk.admin.index');
    Route::get('/tambah/stock/produk/admin', [StockController::class, 'create'])->name('stock-produk.admin.create');
    Route::post('/simpan/stock/produk/admin', [StockController::class, 'store'])->name('stock-produk.admin.store');
    Route::delete('/delete/stock/produk/admin/{id}', [StockController::class, 'destroy'])->name('stock-produk.admin.destroy');
    Route::get('/edit/stock/produk/admin/{id}', [StockController::class, 'edit'])->name('stock-produk.admin.edit');
    Route::post('/update/stock/produk/admin/{id}', [StockController::class, 'update'])->name('stock-produk.admin.update');
    Route::get('/stock/download-excel/admin', [StockController::class, 'downloadExcel'])->name('stock.download.excel.admin');
    Route::get('/stock/download-pdf/admin', [StockController::class, 'downloadPdf'])->name('stock.download.pdf.admin');
    Route::get('/get-produk-by-barcode/stock/{barcode}', [StockController::class, 'produkByBarcode'])->name('get.produk.barcode.stock');
    Route::get('/upload/files/stock/admin', [StockController::class, 'uploadFile'])->name('upload.stock.files.admin');
    Route::get('/download-template/stock/admin', function () {
        $file = storage_path('app/public/stock.xlsx');
        return Response::download($file, 'stock.xlsx');
    })->name('download.template.upload.stock.admin');
    Route::post('/upload-stock-excel/admin', [StockController::class, 'uploadExcel'])->name('upload.stock.excel.admin');
    //  end Stock
    // Size
    Route::get('/size/produk/admin', [SizeController::class, 'index'])->name('size-produk.admin.index');
    Route::get('/tambah/size/produk/admin', [SizeController::class, 'create'])->name('size-produk.admin.create');
    Route::post('/simpan/size/produk/admin', [SizeController::class, 'store'])->name('size-produk.admin.store');
    Route::delete('/delete/size/produk/admin/{id}', [SizeController::class, 'destroy'])->name('size-produk.admin.destroy');
    Route::get('/edit/size/produk/admin/{id}', [SizeController::class, 'edit'])->name('size-produk.admin.edit');
    Route::post('/update/size/produk/admin/{id}', [SizeController::class, 'update'])->name('size-produk.admin.update');
    Route::get('/size/download-excel/admin', [SizeController::class, 'downloadExcel'])->name('size.download.excel.admin');
    Route::get('/size/download-pdf/admin', [SizeController::class, 'downloadPdf'])->name('size.download.pdf.admin');
    Route::get('/upload/files/size/admin', [SizeController::class, 'uploadFile'])->name('upload.size.files.admin');
    Route::get('/download-template/size/admin', function () {
        $file = storage_path('app/public/size.xlsx');
        return Response::download($file, 'size.xlsx');
    })->name('download.template.upload.size.admin');
    Route::post('/upload-size-excel/admin', [sizeController::class, 'uploadExcel'])->name('upload.size.excel.admin');
    //  end Size
});
