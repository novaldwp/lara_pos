<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTabelProduk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->bigIncrements('produk_id');
            $table->string('produk_kode');
            $table->string('produk_nama');
            $table->integer('produk_beli');
            $table->integer('produk_jual');
            $table->string('produk_image');
            $table->bigInteger('kategori_id')->unsigned()->nullable();
            $table->foreign('kategori_id')->references('kategori_id')->on('kategori')->onDelete('set null')->onUpdate('cascade');
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
        Schema::dropIfExists('produk');
    }
}
