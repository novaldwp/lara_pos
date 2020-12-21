<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTabelPembelianDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pembelian', function (Blueprint $table) {
            $table->bigIncrements('detailpembelian_id');
            $table->integer('detailpembelian_jumlah');
            $table->string('detailpembelian_subtotal');
            $table->bigInteger('pembelian_id')->unsigned()->nullable();
            $table->bigInteger('produk_id')->unsigned()->nullable();
            $table->foreign('pembelian_id')->references('pembelian_id')->on('pembelian')->onDelete('set null')->onUpdate('cascade');
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
        Schema::dropIfExists('detail_pembelian');
    }
}
