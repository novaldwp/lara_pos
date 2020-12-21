<?php
use App\PembelianDummy;


Route::get('/', 'HomeController@index')->name('home');

Route::get('/test', 'Master\StokController@test');

// auth with disabble register, reset password and forgot password
Auth::routes(['register' => false, 'reset' => false, 'request' => false]);


// route yang hanya bisa diakses oleh user role 1 => 'admin'
Route::group(['middleware' => ['auth', 'web', 'cekuser:1']], function(){

    Route::resource('kategori', 'Master\KategoriController');
    Route::resource('supplier', 'Master\SupplierController');
    Route::resource('produk', 'Master\ProdukController');
    Route::resource('user', 'Master\UserController');
    Route::resource('member', 'Master\MemberController');
    Route::resource('stok', 'Master\StokController');
    Route::resource('pembelian', 'Master\PembelianController');
    Route::resource('penjualan', 'PenjualanController');

    Route::post('member/get_id_member', 'Master\MemberController@get_id_member');
    Route::get('member/get-member-by-kode/{member_kode}', 'Master\MemberController@get_member_by_kode');
    Route::post('pembelian/get_pembelian_kode', 'Master\PembelianController@get_pembelian_kode');
    Route::post('pembelian/storeDummy', 'Master\PembelianController@storeDummy');
    Route::post('pembelian/delete_detail', 'Master\PembelianController@deleteDummy');

    Route::get('get_pembelian_detail', 'Master\PembelianController@get_pembelian_detail');
    Route::get('get_penjualan_cart', 'PenjualanController@get_penjualan_cart');

    Route::get('produk/{id}/minus_penjualan_cart', 'PenjualanController@minus_penjualan_cart');
    Route::get('produk/{id}/plus_penjualan_cart', 'PenjualanController@plus_penjualan_cart');
    Route::get('produk/{id}/enter_penjualan_cart', 'PenjualanController@enter_penjualan_cart');
    Route::post('produk/clear_penjualan_cart', 'PenjualanController@clear_penjualan_cart');
    Route::post('produk/insert-penjualan-data', 'PenjualanController@insert_penjualan_data');

    Route::get('pembelian/get_produk_by_kode/{kode}', 'Master\PembelianController@get_produk_by_kode');
    Route::post('produk/get_produk_kode', 'Master\ProdukController@get_produk_kode');

    Route::post('produk/insert_penjualan_cart', 'PenjualanController@insert_penjualan_cart');
    Route::get('pembelian/get_by_id/{id}', 'Master\PembelianController@get_by_id');
});

