<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTabelPenjualanDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan_detail', function (Blueprint $table) {
            $table->bigIncrements('detailpenjualan_id');
            $table->integer('detailpenjualan_qty');
            $table->integer('detailpenjualan_harga');
            $table->integer('detailpenjualan_subtotal');
            $table->bigInteger('penjualan_id')->unsigned()->nullable();
            $table->bigInteger('produk_id')->unsigned()->nullable();
            $table->foreign('penjualan_id')->references('penjualan_id')->on('penjualan')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('produk_id')->references('produk_id')->on('produk')->onDelete('set null')->onUpdate('cascade');
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
        Schema::dropIfExists('penjualan_detail');
    }
}
