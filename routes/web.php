<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\WarnaController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\ProductionController;
use App\Http\Controllers\Admin\ProdukController;
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
    // kategori barang
    Route::get('/kategori/admin', [KategoriController::class, 'index'])->name('kategori.admin.index');
    Route::get('/tambah/kategori/admin', [KategoriController::class, 'create'])->name('kategori.admin.create');
    Route::post('/simpan/kategori/admin/store', [KategoriController::class, 'store'])->name('kategori.admin.store');
    Route::delete('/delete/kategori/admin/{id}', [KategoriController::class, 'destroy'])->name('kategori.admin.destroy');
    Route::get('/edit/kategori/admin/{id}', [KategoriController::class, 'edit'])->name('kategori.admin.edit');
    Route::post('/update/kategori/admin/{id}', [KategoriController::class, 'update'])->name('kategori.admin.update');
    Route::get('/kategori/download-excel/admin', [KategoriController::class, 'downloadExcel'])->name('kategori.download.excel.admin');
    //  end kategori barang
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
    Route::get('/production/admin', [ProductionController::class, 'index'])->name('production.admin.index');
    Route::get('/tambah/production/admin', [ProductionController::class, 'create'])->name('production.admin.create');
    Route::post('/simpan/production/admin/store', [ProductionController::class, 'store'])->name('production.admin.store');
    Route::delete('/delete/production/admin/{id}', [ProductionController::class, 'destroy'])->name('production.admin.destroy');
    Route::get('/edit/production/admin/{id}', [ProductionController::class, 'edit'])->name('production.admin.edit');
    Route::post('/update/production/admin/{id}', [ProductionController::class, 'update'])->name('production.admin.update');
    Route::get('/production/download-excel/admin', [ProductionController::class, 'downloadExcel'])->name('production.download.excel.admin');
    Route::get('/penjualan/{id}/preview/admin', [ProductionController::class, 'preview'])->name('purchase-order.preview');
    Route::get('/get-produk/admin/{so_number}', [ProductionController::class, 'getProduk'])->name('get.produk.admin');
    Route::get('/get-produk/admin',  [ProductionController::class, 'getAllProduk'])->name('get.all-produk-admin');
    Route::get('/get-satuans/admin', [ProductionController::class, 'getSatuan'])->name('get.all-satuan.produk-admin');
});
