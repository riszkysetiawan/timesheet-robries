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
use App\Http\Controllers\Admin\AlasanWasteController;
use App\Http\Controllers\Admin\WasteController;
use App\Http\Controllers\Admin\SatuanBarangController;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\PenjualanController;
use App\Http\Controllers\StaffProduksi\ProdukStaffProduksiController;
use App\Http\Controllers\StaffProduksi\DashoardStaffProduksiController;
use App\Http\Controllers\StaffProduksi\SizeStaffProduksiController;
use App\Http\Controllers\StaffProduksi\WarnaStaffProduksiController;
use App\Http\Controllers\StaffProduksi\ProductionStaffProduksiController;
use App\Http\Controllers\OperatorProduksi\DashboardOperatorProduksiController;
use App\Http\Controllers\OperatorProduksi\ProductionOperatorProduksiController;
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
Route::get('/error', function () {
    return view('error.error'); // Arahkan ke view error.error
})->name('eror');

Route::fallback(function () {
    return redirect()->route('eror');
});
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
    Route::get('/upload/files/user/admin', [UserController::class, 'uploadFile'])->name('upload.user.files.admin');
    Route::get('/download-template/user/admin', function () {
        $file = storage_path('app/public/upload user.xlsx');
        return Response::download($file, 'upload user.xlsx');
    })->name('download.template.upload.user.admin');
    Route::post('/upload-user-excel/admin', [UserController::class, 'uploadExcel'])->name('upload.user.excel.admin');
    // user end
    // Profile
    Route::get('/profile/superadmin', [AuthController::class, 'index'])->name('profile.superadmin');
    Route::post('/profile/superadmin/update', [AuthController::class, 'update'])->name('profile-superadmin.update');
    Route::get('/logout/superadmin', [AuthController::class, 'logout'])->name('logout.superadmin');
    //  end profile
    // Warna admin
    Route::get('/warna/admin', [WarnaController::class, 'index'])->name('warna.admin.index');
    Route::get('/tambah/warna/admin', [WarnaController::class, 'create'])->name('warna.admin.create');
    Route::post('/simpan/warna/admin/store', [WarnaController::class, 'store'])->name('warna.admin.store');
    Route::delete('/delete/warna/admin/{id}', [WarnaController::class, 'destroy'])->name('warna.admin.destroy');
    Route::get('/edit/warna/admin/{id}', [WarnaController::class, 'edit'])->name('warna.admin.edit');
    Route::post('/update/warna/admin/{id}', [WarnaController::class, 'update'])->name('warna.admin.update');
    Route::get('/warna/download-excel/admin', [WarnaController::class, 'downloadExcel'])->name('warna.download.excel.admin');
    //  end Warna
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
    // Satuan Barang
    Route::get('/satuan-barang/admin', [SatuanBarangController::class, 'index'])->name('satuan-barang.admin.index');
    Route::get('/tambah/satuan-barang/admin', [SatuanBarangController::class, 'create'])->name('satuan-barang.admin.create');
    Route::post('/simpan/satuan-barang/admin/store', [SatuanBarangController::class, 'store'])->name('satuan-barang.admin.store');
    Route::delete('/delete/satuan-barang/admin/{id}', [SatuanBarangController::class, 'destroy'])->name('satuan-barang.admin.destroy');
    Route::get('/edit/satuan-barang/admin/{id}', [SatuanBarangController::class, 'edit'])->name('satuan-barang.admin.edit');
    Route::post('/update/satuan-barang/admin/{id}', [SatuanBarangController::class, 'update'])->name('satuan-barang.admin.update');
    // end Satuan Barang
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
    // alasan waste
    Route::get('/alasan-waste/admin', [AlasanWasteController::class, 'index'])->name('alasan-waste.admin.index');
    Route::get('/tambah/alasan-waste/admin', [AlasanWasteController::class, 'create'])->name('alasan-waste.admin.create');
    Route::post('/simpan/alasan-waste/admin/store', [AlasanWasteController::class, 'store'])->name('alasan-waste.admin.store');
    Route::delete('/delete/alasan-waste/admin/{id}', [AlasanWasteController::class, 'destroy'])->name('alasan-waste.admin.destroy');
    Route::get('/edit/alasan-waste/admin/{id}', [AlasanWasteController::class, 'edit'])->name('alasan-waste.admin.edit');
    Route::post('/update/alasan-waste/admin/{id}', [AlasanWasteController::class, 'update'])->name('alasan-waste.admin.update');
    // end alasan waste
    // waste admin
    Route::get('/waste-barang/admin', [WasteController::class, 'index'])->name('waste.admin.index');
    Route::get('/tambah/waste/admin', [WasteController::class, 'create'])->name('waste.admin.create');
    Route::post('/simpan/waste/admin/store', [WasteController::class, 'store'])->name('waste.admin.store');
    Route::delete('/delete/waste/admin/{id}', [WasteController::class, 'destroy'])->name('waste.admin.destroy');
    Route::get('/edit/waste/admin/{id}', [WasteController::class, 'edit'])->name('waste.admin.edit');
    Route::post('/update/waste/admin/{id}', [WasteController::class, 'update'])->name('waste.admin.update');
    Route::get('/waste/download-excel/admin', [WasteController::class, 'downloadExcel'])->name('waste.download.excel.admin');
    Route::get('/waste/download-pdf/admin', [WasteController::class, 'downloadPdf'])->name('waste.download.pdf.admin');
    Route::get('/upload/files/waste/admin', [WasteController::class, 'uploadFile'])->name('upload.waste.files.admin');
    Route::get('/download-template/waste/admin', function () {
        $file = storage_path('app/public/template upload waste.xlsx');
        return Response::download($file, 'template upload waste.xlsx');
    })->name('download.template.upload.waste.admin');
    Route::post('/upload-waste-excel/admin', [WasteController::class, 'uploadExcel'])->name('upload.waste.excel.admin');
    // end waste admin
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
        $file = storage_path('app/public/template upload produk.xlsx');
        return Response::download($file, 'template upload produk.xlsx');
    })->name('download.template.upload.produk.admin');
    Route::post('/upload-produk-excel/admin', [ProdukController::class, 'uploadExcel'])->name('upload.produk.admin');
    //  end produk
    // barang
    Route::get('/barang/admin', [BarangController::class, 'index'])->name('barang.admin.index');
    Route::get('/tambah/barang/admin', [BarangController::class, 'create'])->name('barang.admin.create');
    Route::post('/simpan/barang/admin/store', [BarangController::class, 'store'])->name('barang.admin.store');
    Route::delete('/delete/barang/admin/{id}', [BarangController::class, 'destroy'])->name('barang.admin.destroy');
    Route::get('/edit/barang/admin/{id}', [BarangController::class, 'edit'])->name('barang.admin.edit');
    Route::post('/update/barang/admin/{id}', [BarangController::class, 'update'])->name('barang.admin.update');
    Route::get('/barang/download-excel/admin', [BarangController::class, 'downloadExcel'])->name('barang.download.excel.admin');
    Route::get('/upload/files/barang/admin', [BarangController::class, 'uploadFile'])->name('upload.barang.files.admin');
    Route::get('/download-template/barang/admin', function () {
        $file = storage_path('app/public/template upload barang.xlsx');
        return Response::download($file, 'template upload barang.xlsx');
    })->name('download.template.upload.barang.admin');
    Route::post('/upload-barang-excel/admin', [BarangController::class, 'uploadExcel'])->name('upload.barang.admin');
    // end barang
    // production
    Route::get('/production/admin', [ProductionController::class, 'index'])->name('production.admin.index');
    Route::post('/production/admin', [ProductionController::class, 'index'])->name('production.admin.index');
    Route::get('/tambah/production/admin', [ProductionController::class, 'create'])->name('production.admin.create');
    Route::post('/simpan/production/admin/store', [ProductionController::class, 'store'])->name('production.admin.store');
    Route::delete('/delete/production/admin/{id}', [ProductionController::class, 'destroy'])->name('production.admin.destroy');
    Route::get('/edit/production/admin/{id}', [ProductionController::class, 'edit'])->name('production.admin.edit');
    Route::get('/edit-timer/production/admin/{id}', [ProductionController::class, 'editTimer'])->name('production.admin.edit.timer');
    Route::post('/production/update-timer/admin', [ProductionController::class, 'updateTimer'])->name('admin.production.updateTimer');
    Route::post('/admin/production/delete-timer', [ProductionController::class, 'deleteTimer'])->name('admin.production.deleteTimer');
    Route::get('/mulai-timer/production/admin/{id}', [ProductionController::class, 'timer'])->name('timer-start.production.admin');
    Route::get('/production/admin/timerbarcode/{barcode}', [ProductionController::class, 'timerbarcode'])
        ->where('barcode', '.*') // Allow special characters
        ->name('production.admin.timerbarcode');
    Route::post('/production/start-timer/admin', [ProductionController::class, 'startTimer'])->name('production.startTimer');
    Route::post('/update/production/admin/{id}', [ProductionController::class, 'update'])->name('production.admin.update');
    Route::get('/production/download-excel/admin', [ProductionController::class, 'downloadExcel'])->name('production.download.excel.admin');
    Route::get('/show/production/admin/{id}', [ProductionController::class, 'show'])->name('detail.production.admin');
    Route::get('/get-produk/admin/{so_number}', [ProductionController::class, 'getProduk'])->name('get.produk.admin');
    Route::get('/get-produk/admin',  [ProductionController::class, 'getAllProduk'])->name('get.all-produk-admin');
    Route::get('/get-ukuran/admin',  [ProductionController::class, 'getAllUkuran'])->name('get.all-ukuran-admin');
    Route::get('/get-warna/admin', [ProductionController::class, 'getWarna'])->name('get.all-warna.produk-admin');
    // Route::get('/timer/download-excel/admin', [ProductionController::class, 'downloadExcel'])->name('timer.download.excel.admin');
    Route::get('/upload/production/admin', [ProductionController::class, 'uploadFile'])->name('upload.production.files.admin');
    Route::get('/download-template/production/admin', function () {
        $file = storage_path('app/public/template upload production.xlsx');
        return Response::download($file, 'template upload production.xlsx');
    })->name('download.template.upload.production.admin');
    Route::post('production/{id}/update-finish-rework/admin', [ProductionController::class, 'updateFinishRework'])->name('production.updateFinishRework.admin');
    Route::post('/upload-production-excel/admin', [ProductionController::class, 'uploadExcel'])->name('upload.production.excel.admin');
    Route::post('/print-labels', [ProductionController::class, 'printSelected'])->name('print.labels');
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
        $file = storage_path('app/public/template upload stock.xlsx');
        return Response::download($file, 'template upload stock.xlsx');
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
        $file = storage_path('app/public/template upload ukuran.xlsx');
        return Response::download($file, 'template upload ukuran.xlsx');
    })->name('download.template.upload.size.admin');
    Route::post('/upload-size-excel/admin', [sizeController::class, 'uploadExcel'])->name('upload.size.excel.admin');
    //  end Size
    // Penjualan area
    Route::get('/penjualan/admin', [PenjualanController::class, 'index'])->name('penjualan.admin.index');
    Route::get('/tambah/penjualan/admin', [PenjualanController::class, 'create'])->name('penjualan.admin.create');
    Route::post('/simpan/penjualan/admin/store', [PenjualanController::class, 'store'])->name('penjualan.admin.store');
    Route::delete('/delete/penjualan/admin/{id}', [PenjualanController::class, 'destroy'])->name('penjualan.admin.destroy');
    Route::get('/edit/penjualan/admin/{id}', [PenjualanController::class, 'edit'])->name('penjualan.admin.edit');
    Route::post('/update/penjualan/admin/{id}', [PenjualanController::class, 'update'])->name('penjualan.admin.update');
    // end Penjualan area
});

Route::middleware(['role:Staff Produksi'])->group(function () {
    Route::get('/dashboard-produksi', [DashoardStaffProduksiController::class, 'index'])->name('dashboard.staff-produksi');
    // Warna
    Route::get('/warna/production-staff', [WarnaStaffProduksiController::class, 'index'])->name('warna.production-staff.index');
    Route::get('/tambah/warna/production-staff', [WarnaStaffProduksiController::class, 'create'])->name('warna.production-staff.create');
    Route::post('/simpan/warna/production-staff/store', [WarnaStaffProduksiController::class, 'store'])->name('warna.production-staff.store');
    Route::delete('/delete/warna/production-staff/{id}', [WarnaStaffProduksiController::class, 'destroy'])->name('warna.production-staff.destroy');
    Route::get('/edit/warna/production-staff/{id}', [WarnaStaffProduksiController::class, 'edit'])->name('warna.production-staff.edit');
    Route::post('/update/warna/production-staff/{id}', [WarnaStaffProduksiController::class, 'update'])->name('warna.production-staff.update');
    Route::get('/warna/download-excel/production-staff', [WarnaStaffProduksiController::class, 'downloadExcel'])->name('warna.download.excel.production-staff');
    //  end
    // produk
    Route::get('/produk/production-staff', [ProdukStaffProduksiController::class, 'index'])->name('produk.production-staff.index');
    Route::get('/tambah/produk/production-staff', [ProdukStaffProduksiController::class, 'create'])->name('produk.production-staff.create');
    Route::post('/simpan/produk/production-staff/store', [ProdukStaffProduksiController::class, 'store'])->name('produk.production-staff.store');
    Route::delete('/delete/produk/production-staff/{id}', [ProdukStaffProduksiController::class, 'destroy'])->name('produk.production-staff.destroy');
    Route::get('/edit/produk/production-staff/{id}', [ProdukStaffProduksiController::class, 'edit'])->name('produk.production-staff.edit');
    Route::post('/update/produk/production-staff/{id}', [ProdukStaffProduksiController::class, 'update'])->name('produk.production-staff.update');
    Route::get('/produk/download-excel/production-staff', [ProdukStaffProduksiController::class, 'downloadExcel'])->name('produk.download.excel.production-staff');
    Route::get('/upload/files/produk/production-staff', [ProdukStaffProduksiController::class, 'uploadFile'])->name('upload.produk.files.production-staff');
    Route::get('/download-template/produk/production-staff', function () {
        $file = storage_path('app/public/template upload produk.xlsx');
        return Response::download($file, 'template upload produk.xlsx');
    })->name('download.template.upload.produk.production-staff');
    Route::post('/upload-produk-excel/production-staff', [ProdukStaffProduksiController::class, 'uploadExcel'])->name('upload.produk.production-staff');
    //  end produk   // Size
    Route::get('/size/produk/production-staff', [SizeStaffProduksiController::class, 'index'])->name('size-produk.production-staff.index');
    Route::get('/tambah/size/produk/production-staff', [SizeStaffProduksiController::class, 'create'])->name('size-produk.production-staff.create');
    Route::post('/simpan/size/produk/production-staff', [SizeStaffProduksiController::class, 'store'])->name('size-produk.production-staff.store');
    Route::delete('/delete/size/produk/production-staff/{id}', [SizeStaffProduksiController::class, 'destroy'])->name('size-produk.production-staff.destroy');
    Route::get('/edit/size/produk/production-staff/{id}', [SizeStaffProduksiController::class, 'edit'])->name('size-produk.production-staff.edit');
    Route::post('/update/size/produk/production-staff/{id}', [SizeStaffProduksiController::class, 'update'])->name('size-produk.production-staff.update');
    Route::get('/size/download-excel/production-staff', [SizeStaffProduksiController::class, 'downloadExcel'])->name('size.download.excel.production-staff');
    Route::get('/size/download-pdf/production-staff', [SizeStaffProduksiController::class, 'downloadPdf'])->name('size.download.pdf.production-staff');
    Route::get('/upload/files/size/production-staff', [SizeStaffProduksiController::class, 'uploadFile'])->name('upload.size.files.production-staff');
    Route::get('/download-template/size/production-staff', function () {
        $file = storage_path('app/public/template upload ukuran.xlsx');
        return Response::download($file, 'template upload ukuran.xlsx');
    })->name('download.template.upload.size.production-staff');
    Route::post('/upload-size-excel/production-staff', [SizeStaffProduksiController::class, 'uploadExcel'])->name('upload.size.excel.production-staff');
    //  end Size
    // production
    Route::get('/production/production-staff', [ProductionStaffProduksiController::class, 'index'])->name('production.production-staff.index');
    Route::post('/production/production-staff', [ProductionStaffProduksiController::class, 'index'])->name('production.production-staff.index');
    Route::get('/tambah/production/production-staff', [ProductionStaffProduksiController::class, 'create'])->name('production.production-staff.create');
    Route::post('/simpan/production/production-staff/store', [ProductionStaffProduksiController::class, 'store'])->name('production.production-staff.store');
    Route::delete('/delete/production/production-staff/{id}', [ProductionStaffProduksiController::class, 'destroy'])->name('production.production-staff.destroy');
    Route::get('/edit/production/production-staff/{id}', [ProductionStaffProduksiController::class, 'edit'])->name('production.production-staff.edit');
    Route::get('/edit-timer/production/production-staff/{id}', [ProductionStaffProduksiController::class, 'editTimer'])->name('production.production-staff.edit.timer');
    Route::post('/production/update-timer/production-staff', [ProductionStaffProduksiController::class, 'updateTimer'])->name('production-staff.production.updateTimer');
    Route::post('/production-staff/production/delete-timer', [ProductionStaffProduksiController::class, 'deleteTimer'])->name('production-staff.production.deleteTimer');
    Route::get('/mulai-timer/production/production-staff/{id}', [ProductionStaffProduksiController::class, 'timer'])->name('timer-start.production.production-staff');
    // Route::get('/production/production-staff/timerbarcode/{barcode}', [ProductionStaffProduksiController::class, 'timerbarcode'])->name('production.production-staff.timerbarcode');
    Route::get('/production/production-staff/timerbarcode/{barcode}', [ProductionStaffProduksiController::class, 'timerbarcode'])
        ->where('barcode', '.*') // Allow special characters
        ->name('production.production-staff.timerbarcode');
    Route::post('/production/start-timer/staff-produksi', [ProductionStaffProduksiController::class, 'startTimer'])->name('production.startTimer.staffproduksi');
    Route::post('/update/production/production-staff/{id}', [ProductionStaffProduksiController::class, 'update'])->name('production.production-staff.update');
    Route::get('/production/download-excel/production-staff', [ProductionStaffProduksiController::class, 'downloadExcel'])->name('production.download.excel.production-staff');
    Route::get('/show/production/production-staff/{id}', [ProductionStaffProduksiController::class, 'show'])->name('detail.production.production-staff');
    Route::get('/get-produk/production-staff/{so_number}', [ProductionStaffProduksiController::class, 'getProduk'])->name('get.produk.production-staff');
    Route::get('/get-produk/production-staff',  [ProductionStaffProduksiController::class, 'getAllProduk'])->name('get.all-produk-production-staff');
    Route::get('/get-ukuran/production-staff',  [ProductionStaffProduksiController::class, 'getAllUkuran'])->name('get.all-ukuran-production-staff');
    Route::get('/get-warna/production-staff', [ProductionStaffProduksiController::class, 'getWarna'])->name('get.all-warna.produk-production-staff');
    // Route::get('/timer/download-excel/production-staff', [ProductionStaffProduksiController::class, 'downloadExcel'])->name('timer.download.excel.production-staff');
    Route::get('/upload/production/production-staff', [ProductionStaffProduksiController::class, 'uploadFile'])->name('upload.production.files.production-staff');
    Route::get('/download-template/production/production-staff', function () {
        $file = storage_path('app/public/template upload production.xlsx');
        return Response::download($file, 'template upload production.xlsx');
    })->name('download.template.upload.production.production-staff');
    Route::post('production/{id}/update-finish-rework/production-staff', [ProductionStaffProduksiController::class, 'updateFinishRework'])->name('production.updateFinishRework.production-staff');
    Route::post('/upload-production-excel/production-staff', [ProductionStaffProduksiController::class, 'uploadExcel'])->name('upload.production.excel.production-staff');
    Route::post('/print-labels/production-staff', [ProductionStaffProduksiController::class, 'printSelected'])->name('print.labels.production-staff');
    // end production
    // Profile
    Route::get('/profile/production-staff', [AuthController::class, 'indexStaffProduksi'])->name('profile.production-staff');
    Route::post('/profile/production-staff/update', [AuthController::class, 'updateStaffProduksi'])->name('profile-production-staff.update');
    Route::get('/logout/production-staff', [AuthController::class, 'logoutStaffProduksi'])->name('logout.production-staff');
    //  end profile
});
Route::middleware(['role:Operator Produksi,Quality Control'])->group(function () {
    Route::get('/dashboard-operator-produksi', [DashboardOperatorProduksiController::class, 'index'])->name('dashboard.operator-produksi');
    //
    Route::get('/profile/operator-produksi', [AuthController::class, 'indexOperatorProduksi'])->name('profile.operator-produksi');
    Route::post('/profile/operator-produksi/update', [AuthController::class, 'updateOperatorProduksi'])->name('profile-operator-produksi.update');
    Route::get('/logout/operator-produksi', [AuthController::class, 'logoutOperatorProduksi'])->name('logout.operator-produksi');
    // profile end
    // production
    Route::get('/production/operator-produksi', [ProductionOperatorProduksiController::class, 'index'])->name('production.operator-produksi.index');
    Route::post('/production/operator-produksi', [ProductionOperatorProduksiController::class, 'index'])->name('production.operator-produksi.index');
    Route::get('/tambah/production/operator-produksi', [ProductionOperatorProduksiController::class, 'create'])->name('production.operator-produksi.create');
    Route::post('/simpan/production/operator-produksi/store', [ProductionOperatorProduksiController::class, 'store'])->name('production.operator-produksi.store');
    Route::delete('/delete/production/operator-produksi/{id}', [ProductionOperatorProduksiController::class, 'destroy'])->name('production.operator-produksi.destroy');
    Route::get('/edit/production/operator-produksi/{id}', [ProductionOperatorProduksiController::class, 'edit'])->name('production.operator-produksi.edit');
    Route::get('/edit-timer/production/operator-produksi/{id}', [ProductionOperatorProduksiController::class, 'editTimer'])->name('production.operator-produksi.edit.timer');
    Route::post('/production/update-timer', [ProductionOperatorProduksiController::class, 'updateTimer'])->name('operator-produksi.production.updateTimer');
    Route::post('/operator-produksi/production/delete-timer', [ProductionOperatorProduksiController::class, 'deleteTimer'])->name('operator-produksi.production.deleteTimer');
    Route::get('/mulai-timer/production/operator-produksi/{id}', [ProductionOperatorProduksiController::class, 'timer'])->name('timer-start.production.operator-produksi');
    // Route::get('/production/operator-produksi/timerbarcode/{barcode}', [ProductionOperatorProduksiController::class, 'timerbarcode'])->name('production.operator-produksi.timerbarcode');
    Route::get('/production/operator-produksi/timerbarcode/{barcode}', [ProductionOperatorProduksiController::class, 'timerbarcode'])
        ->where('barcode', '.*') // Allow special characters
        ->name('production.operator-produksi.timerbarcode');
    Route::post('/production/start-timer/operator-produksi', [ProductionOperatorProduksiController::class, 'startTimer'])->name('production.startTimer.operator-produksi');
    Route::post('/update/production/operator-produksi/{id}', [ProductionOperatorProduksiController::class, 'update'])->name('production.operator-produksi.update');
    Route::get('/production/download-excel/operator-produksi', [ProductionOperatorProduksiController::class, 'downloadExcel'])->name('production.download.excel.operator-produksi');
    Route::get('/show/production/operator-produksi/{id}', [ProductionOperatorProduksiController::class, 'show'])->name('detail.production.operator-produksi');
    Route::get('/get-produk/operator-produksi/{so_number}', [ProductionOperatorProduksiController::class, 'getProduk'])->name('get.produk.operator-produksi');
    Route::get('/get-produk/operator-produksi',  [ProductionOperatorProduksiController::class, 'getAllProduk'])->name('get.all-produk-operator-produksi');
    Route::get('/get-ukuran/operator-produksi',  [ProductionOperatorProduksiController::class, 'getAllUkuran'])->name('get.all-ukuran-operator-produksi');
    Route::get('/get-warna/operator-produksi', [ProductionOperatorProduksiController::class, 'getWarna'])->name('get.all-warna.produk-operator-produksi');
    // Route::get('/timer/download-excel/operator-produksi', [ProductionOperatorProduksiController::class, 'downloadExcel'])->name('timer.download.excel.operator-produksi');
    Route::get('/upload/production/operator-produksi', [ProductionOperatorProduksiController::class, 'uploadFile'])->name('upload.production.files.operator-produksi');
    Route::get('/download-template/production/operator-produksi', function () {
        $file = storage_path('app/public/template upload production.xlsx');
        return Response::download($file, 'template upload production.xlsx');
    })->name('download.template.upload.production.operator-produksi');
    Route::post('production/{id}/update-finish-rework/operator-produksi', [ProductionOperatorProduksiController::class, 'updateFinishRework'])->name('production.updateFinishRework.operator-produksi');
    Route::post('/upload-production-excel/operator-produksi', [ProductionOperatorProduksiController::class, 'uploadExcel'])->name('upload.production.excel.operator-produksi');
    Route::post('/print-labels/operator-produksi', [ProductionOperatorProduksiController::class, 'printSelected'])->name('print.labels.operator-produksi');
    // end production
});
