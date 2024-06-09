<?php

use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\HampersController;
use App\Http\Controllers\laporanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\pembayaranController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\prosesController;
use App\Http\Controllers\RegistCustomerController;
use App\Http\Controllers\RegistPegawaiController;
use App\Http\Controllers\ResepController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\transaksiController;
use Illuminate\Support\Facades\Route;

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
Route::get('/home-admin', [LoginController::class, 'homeAdmin'])->name('home-admin');

Route::get('', [LoginController::class, 'login'])->name('login');
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/action-login', [LoginController::class, 'actionLogin'])->name('action-login');

Route::post('/logout_customer', [LoginController::class, 'actionLogoutCustomer'])->name('logout-customer');
Route::post('/logout_pegawai', [LoginController::class, 'actionLogoutPegawai'])->name('logout-pegawai');

Route::get('/register', [RegistCustomerController::class, 'register'])->name('register');
Route::post('/action-register', [RegistCustomerController::class, 'actionRegister'])->name('action-register');
Route::get('register/verifycustomer/{verify_key}', [RegistCustomerController::class,'verify'])->name('verify');

Route::get('/register-peg', [RegistPegawaiController::class, 'register'])->name('register-pegawai');
Route::post('/action-register-peg', [RegistPegawaiController::class, 'actionRegister'])->name('action-register-peg');
Route::get('register/verifypegawai/{verify_key}', [RegistPegawaiController::class,'verify'])->name('verify-cust');

Route::get('reset-email-cust', [PasswordController::class, 'inputEmailCust'])->name('reset-email-cust');
Route::post('reset-customer', [PasswordController::class, 'actionResetCust'])->name('reset-password-cust');
Route::get('reset-password-cust/{token}', [PasswordController::class, 'showResetFormCust'])->name('password-reset-cust');
Route::get('reset-password-cust/wrong', [PasswordController::class, 'showResetFormCust'])->name('password-reset-view-cust');
Route::post('reset-password-cust/cust', [PasswordController::class, 'resetPasswordCust'])->name('reset-cust');

Route::get('reset-email-pegawai', [PasswordController::class, 'inputEmailPeg'])->name('reset-email-peg');
Route::post('reset-pegawai', [PasswordController::class, 'actionResetPeg'])->name('reset-password-peg');
Route::get('reset-password-pegawai/{token}', [PasswordController::class, 'showResetFormPeg'])->name('password-reset-peg');
Route::get('reset-password-pegawai/wrong', [PasswordController::class, 'showResetFormCust'])->name('password-reset-view-peg');
Route::post('reset-password-pegawai/cust', [PasswordController::class, 'resetPasswordPeg'])->name('reset-peg');

//mo
Route::get('/home-mo', [LoginController::class, 'homeMo'])->name('home-mo');

Route::get('/mo/pegawai/index', [PegawaiController::class, 'index'])->name('index-pegawai');
Route::get('/mo/pegawai/edit/{id_pegawai}', [PegawaiController::class, 'edit'])->name('edit-pegawai');
Route::put('/mo/pegawai/action-edit/{id_pegawai}', [PegawaiController::class, 'update'])->name('update-pegawai');
Route::delete('/mo/pegawai/action-destroy/{id_pegawai}', [PegawaiController::class, 'destroy'])->name('destroy-pegawai');

Route::get('/mo/register-peg', [RegistPegawaiController::class, 'register'])->name('register-pegawai');
Route::post('/mo/action-register-peg', [RegistPegawaiController::class, 'actionRegister'])->name('action-register-peg');
Route::get('/mo/register/verifypegawai/{verify_key}', [RegistPegawaiController::class,'verify'])->name('verify-peg');

Route::get('/mo/role/index', [RoleController::class, 'index'])->name('index-role');
Route::get('/mo/role/create', [RoleController::class, 'create'])->name('create-role');
Route::post('/mo/role/store', [RoleController::class, 'store'])->name('store-role');
Route::get('/mo/role/edit/{id_role}', [RoleController::class, 'edit'])->name('edit-role');
Route::put('/mo/role/update/{id_role}', [RoleController::class, 'update'])->name('update-role');
Route::delete('/mo/role/delete/{id_role}', [RoleController::class, 'destroy'])->name('destroy-role');

Route::get('/mo/presensi/index', [PresensiController::class, 'indexMo'])->name('index-presensi');
Route::get('/mo/presensi/create', [PresensiController::class, 'createMo'])->name('create-presensi');
Route::post('/mo/presensi/store', [PresensiController::class, 'storeMo'])->name('store-presensi');
Route::get('/mo/presensi/edit/{id_presensi}', [PresensiController::class, 'editMo'])->name('edit-presensi');
Route::put('/mo/presensi/update/{id_presensi}', [PresensiController::class, 'updateMo'])->name('update-presensi');

Route::get('/home-mo/konfirmasi', [TransaksiController::class, 'konfirmasiProses'])->name('transaksi.konfirmasiProses');

//admin
Route::get('/home-admin', [LoginController::class, 'homeAdmin'])->name('home-admin');

Route::get('/home-admin/produk', [ProdukController::class, 'index'])->name('index-produk');
Route::get('/home-admin/{id_produk}/detail', [ProdukController::class, 'detail'])->name('detail-produk');
Route::get('/home-admin/create', [ProdukController::class, 'create'])->name('create-produk');
Route::post('/home-admin/store', [ProdukController::class, 'store'])->name('store-produk');
Route::get('/home-admin/edit', [ProdukController::class, 'edit'])->name('edit-produk');
Route::get('/home-admin/edit-stock/{id_produk}', [ProdukController::class, 'editStock'])->name('editStock-produk');
Route::put('/home-admin/updateStok/{id_produk}', [produkController::class, 'update_stock'])->name('produk.updateStok');
Route::get('/home-admin/destroy-stock', [ProdukController::class, 'destroy'])->name('destroy-produk');
Route::get('/home-admin/search', [ProdukController::class, 'search'])->name('search-produk');



Route::get('/resep', function () {
    return view('/resep');
})->middleware('auth');

Route::resource('/resep', ResepController::class);

Route::get('/search/resep', [resepController::class, 'search'])->name('resep.search');
Route::get('resep/detail/{id_resep}', [resepController::class, 'detail'])->name('resep.detail');
Route::get('resep/editResep/{id_resep}', [ResepController::class, 'editResep'])->name('resep.editResep');
Route::put('resep/updateResep/{id_resep}', [resepController::class, 'updateResep'])->name('resep.updateResep');
Route::delete('resep/kurangi/{id_bahan_baku}', [resepController::class, 'kurangi'])->name('resep.kurangi');


Route::get('/bahan', function () {
    return view('bahan');
});

Route::resource('/bahan', BahanBakuController::class);
Route::get('/search/bahan', [BahanBakuController::class, 'search'])->name('bahan.search');
Route::get('dataStokProduk', [produkController::class, 'dataProdukHome'])->name('dataStokProduk');
Route::get('produk/stok/{id_produk}', [produkController::class, 'stok'])->name('produk.stok');

Route::get('/transaksi', function () {
    return view('transaksi');
});

Route::resource('/transaksi', TransaksiController::class);

Route::get('transaksi/create/{id_customer}', [TransaksiController::class, 'create'])->name('transaksi.create');

Route::get('transaksi/cekPesanan/{id_customer}', [TransaksiController::class, 'cekPesanan'])->name('transaksi.cekPesanan');

Route::get('transaksi/createTransaksi', [TransaksiController::class, 'createTransaksi'])->name('transaksi.createTransaksi');

Route::get('/search/transaksi', [TransaksiController::class, 'search'])->name('transaksi.search');

Route::get('transaksi/keranjang/{nomor_transaksi}', [TransaksiController::class, 'keranjang'])->name('transaksi.keranjang');

Route::get('transaksi/tambahProduk/{nomor_transaksi}', [TransaksiController::class, 'tambahProduk'])->name('transaksi.tambahProduk');

Route::put('transaksi/inputProduk/{nomor_transaksi}', [TransaksiController::class, 'inputProduk'])->name('transaksi.inputProduk');

Route::get('transaksi/tambahPengambilan/{nomor_transaksi}', [TransaksiController::class, 'tambahPengambilan'])->name('transaksi.tambahPengambilan');

Route::put('transaksi/inputPengambilan/{nomor_transaksi}', [TransaksiController::class, 'inputPengambilan'])->name('transaksi.inputPengambilan');

Route::get('transaksi/statusPesanan/{nomor_transaksi}', [TransaksiController::class, 'statusPesanan'])->name('transaksi.statusPesanan');

Route::get('transaksi/summary/{nomor_transaksi}', [TransaksiController::class, 'summary'])->name('transaksi.summary');

Route::get('transaksi/cetakNota/{nomor_transaksi}', [transaksiController::class, 'cetakNota'])->name('transaksi.cetakNota');

Route::get('transaksi/bayar/{nomor_transaksi}', [TransaksiController::class, 'bayar'])->name('transaksi.bayar');

Route::delete('transaksi/kurangi/{nomor_transaksi}', [TransaksiController::class, 'kurangi'])->name('transaksi.kurangi');

Route::put('transaksi/kurangiStok/{nomor_transaksi}', [transaksiController::class, 'kurangiStok'])->name('transaksi.kurangiStok');

Route::get('cekPesanan', [TransaksiController::class, 'cekPesanan'])->name('cekPesanan');

Route::get('pembayaran/waitingList', [pembayaranController::class, 'waitingList'])->name('pembayaran.waitingList');

Route::get('pembayaran/konfirmasiPembayaran', [pembayaranController::class, 'konfirmasiPembayaran'])->name('pembayaran.konfirmasiPembayaran');

Route::patch('pembayaran/inputJarak/{nomor_transaksi}', [pembayaranController::class, 'inputJarak'])->name('pembayaran.inputJarak');

Route::put('pembayaran/inputStatusPembayaran/{nomor_transaksi}', [pembayaranController::class, 'inputStatusPembayaran'])->name('pembayaran.inputStatusPembayaran');

Route::put('transaksi/inputPembayaran/{nomor_transaksi}', [TransaksiController::class, 'inputPembayaran'])->name('transaksi.inputPembayaran');

Route::get('produk/detailStok/{id_produk}', [produkController::class, 'detailStok'])->name('produk.detailStok');
Route::get('hampers/detailStok/{id_hampers}', [HampersController::class, 'detailStok'])->name('hampers.detailStok');

Route::get('proses/pesananHarian', [prosesController::class, 'pesananHarian'])->name('proses.pesananHarian');
Route::put('proses/kurangiStok/{nomor_transaksi}', [prosesController::class, 'kurangiStok'])->name('proses.kurangiStok');

Route::get('mo/laporan', function () {
    return view('laporan.index');
});

Route::get('laporan/laporanBahanBaku', [laporanController::class, 'laporanBahanBaku'])->name('laporan.laporanBahanBaku');

Route::get('laporan/laporanPenjualanProduk', [laporanController::class, 'laporanPenjualanProduk'])->name('laporan.laporanPenjualanProduk');

Route::get('transaksi/cetakNota/{nomor_transaksi}', [TransaksiController::class, 'cetakNota'])->name('transaksi.cetakNota');