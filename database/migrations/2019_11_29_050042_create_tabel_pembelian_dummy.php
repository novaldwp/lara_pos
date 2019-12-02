<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTabelPembelianDummy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelian_dummy', function (Blueprint $table) {
            $table->bigIncrements('pembeliandummy_id');
            $table->integer('produk_id');
            $table->integer('pembelian_jumlah');
            $table->integer('produk_beli');
            $table->integer('subtotal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembelian_dummy');
    }
}
