<?php
use App\PembelianDummy;


Route::get('/', 'HomeController@index')->name('home');

Route::get('/test', 'Master\StokController@test');

// auth with disabble register, reset password and forgot password
Auth::routes(['register' => false, 'reset' => false, 'request' => false]);

// route yang hanya bisa diakses oleh user role 1 => 'admin'
Route::group(['middleware' => 'web', 'cekuser:1'], function(){

    Route::resource('kategori', 'Master\KategoriController');
    Route::resource('supplier', 'Master\SupplierController');
    Route::resource('produk', 'Master\ProdukController');
    Route::resource('user', 'Master\UserController');
    Route::resource('member', 'Master\MemberController');
    Route::resource('stok', 'Master\StokController');
    Route::resource('pembelian', 'Master\PembelianController');
    Route::resource('penjualan', 'PenjualanController');

    Route::post('member/get_id_member', 'Master\MemberController@get_id_member');
    Route::post('pembelian/get_pembelian_kode', 'Master\PembelianController@get_pembelian_kode');
    Route::post('pembelian/storeDummy', 'Master\PembelianController@storeDummy');
    Route::post('pembelian/delete_detail', 'Master\PembelianController@deleteDummy');
    Route::get('get_pembelian_detail', 'Master\PembelianController@get_pembelian_detail');
    Route::get('pembelian/get_produk_by_kode/{kode}', 'Master\PembelianController@get_produk_by_kode');
    Route::post('produk/get_produk_kode', 'Master\ProdukController@get_produk_kode');

    Route::get('pembelian/get_by_id/{id}', 'Master\PembelianController@get_by_id');
});
