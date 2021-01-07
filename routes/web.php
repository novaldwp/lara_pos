<?php
use App\PembelianDummy;


// auth with disabble register, reset password and forgot password
Auth::routes(['register' => false, 'reset' => false, 'request' => false]);
Route::get('coba', function() {
    return view('coba');
});

// route yang hanya bisa diakses yang sudah punya auth
Route::group(['middleware' => ['auth', 'web']], function(){
    Route::get('/', 'Main\DashboardController@index')->name('home');
    Route::get('user/edit-profile/{id}', 'Main\UserController@editProfile');
    Route::post('user/update-profile', 'Main\UserController@updateProfile');
    Route::post('user/update-password', 'Main\UserController@updatePassword');

    // route yang hanya bisa diakses oleh user role 1 => 'admin'
    Route::group(['middleware' => ['cekuser:1']], function () {
        Route::group(['prefix' => 'report', 'as' => 'report.'], function() {
            Route::resource('penjualan', 'Report\ReportPenjualanController')
                ->only(['index', 'show']);
                Route::post('penjualan/toPDF', 'Report\ReportPenjualanController@exportToPDF');
            Route::resource('pembelian', 'Report\ReportPembelianController')
                ->only(['index', 'show']);
            Route::post('pembelian/toPDF', 'Report\ReportPembelianController@exportToPDF');
        });
        Route::resource('user', 'Main\UserController')
            ->except(['create', 'show']);
        Route::resource('setting', 'Main\SettingController');
    });

    // route yang hanya bisa diakses oleh user role 2 => 'petugas'
    Route::group(['middleware' => ['cekuser:2']], function () {
        Route::group(['prefix' => 'master', 'as' => 'master.'], function() {
            Route::resource('kategori', 'Master\KategoriController')
                ->except(['create', 'show']);
            Route::resource('supplier', 'Master\SupplierController')
                ->except(['create', 'show']);
            Route::resource('produk', 'Master\ProdukController')
                ->except(['create', 'show']);
            Route::get('produk/getProductCode', 'Master\ProdukController@getProductCode');
            Route::get('produk/getProductByCode/{kode}', 'Master\ProdukController@getProductByCode');
            Route::get('produk/getProductById/{id}', 'Master\ProdukController@getProductById');
        });
        Route::resource('stok', 'Main\StokController')
            ->except(['create', 'show']);
        Route::resource('member', 'Main\MemberController')
            ->except(['create', 'show']);
        Route::get('member/createMemberCode', 'Main\MemberController@createMemberCode');
        Route::get('member/getMemberByCode/{member_kode}', 'Main\MemberController@getMemberByCode');
        Route::group(['prefix' => 'transaction', 'as' => 'transaction.'], function() {
            // penjualan
            Route::resource('penjualan', 'Transaction\PenjualanController')
                ->only(['index']);
            Route::post('penjualan/clearPenjualanCart', 'Transaction\PenjualanController@clearPenjualanCart');
            Route::post('penjualan/insertPenjualanCart', 'Transaction\PenjualanController@insertPenjualanCart');
            Route::get('penjualan/getPenjualanCart', 'Transaction\PenjualanController@getPenjualanCart');
            Route::get('penjualan/getPenjualanCode', 'Transaction\PenjualanController@getPenjualanCode');
            Route::get('penjualan/{id}/plusPenjualanCartQty', 'Transaction\PenjualanController@plusPenjualanCartQty');
            Route::get('penjualan/{id}/minusPenjualanCartQty', 'Transaction\PenjualanController@minusPenjualanCartQty');
            Route::get('penjualan/{id}/enterPenjualanCartQty', 'Transaction\PenjualanController@enterPenjualanCartQty');
            Route::get('penjualan/{id}/deletePenjualanCartItem', 'Transaction\PenjualanController@deletePenjualanCartItem');
            Route::post('penjualan/insertPenjualanData', 'Transaction\PenjualanController@insertPenjualanData');

            // pembelian
            Route::resource('pembelian', 'Transaction\PembelianController')
                ->only(['index', 'store']);
            Route::get('pembelian/getPembelianCode', 'Transaction\PembelianController@getPembelianCode');
            Route::post('pembelian/insertPembelianCart', 'Transaction\PembelianController@insertPembelianCart');
            Route::get('pembelian/{id}/enterPembelianCartQty', 'Transaction\PembelianController@enterPembelianCartQty');
            Route::get('pembelian/{id}/deletePembelianCartItem', 'Transaction\PembelianController@deletePembelianCartItem');
            Route::post('pembelian/deleteDummy', 'Transaction\PembelianController@deleteDummy');
            Route::get('getPembelianDetail', 'Transaction\PembelianController@getPembelianDetail');
        });
    });
});

