<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPenjualansTable extends Migration
{
    public function up()
    {
        Schema::create('detail_penjualans', function (Blueprint $table) {
            $table->bigIncrements('detail_penjualanid'); // Primary key
            $table->unsignedBigInteger('penjualanid');  // Foreign key ke tabel penjualans
            $table->unsignedBigInteger('Produkid');     // Foreign key ke tabel produks
            $table->integer('JumlahProduk');
            $table->decimal('Subtotal', 10, 2);
            $table->timestamps();

            // Foreign keys
            $table->foreign('penjualanid')->references('penjualanid')->on('penjualans')->onDelete('cascade');
            $table->foreign('Produkid')->references('Produkid')->on('produks')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_penjualans');
    }
}
