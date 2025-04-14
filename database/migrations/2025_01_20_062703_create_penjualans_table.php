<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualansTable extends Migration
{
    public function up()
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->bigIncrements('penjualanid'); // Primary key
            $table->date('TanggalPenjualan');
            $table->decimal('TotalHarga', 10, 2);
            $table->decimal('JumlahBayar', 10, 2);
            $table->decimal('Kembalian', 10, 2);
            $table->enum('MetodePembayaran', ['cash', 'debit', 'e-wallet', 'dana']);
            $table->unsignedBigInteger('Pelangganid'); // Foreign key

            // Foreign key reference to `Pelangganid` in `pelanggans`
            $table->foreign('Pelangganid')->references('Pelangganid')->on('pelanggans')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penjualans');
    }
}
