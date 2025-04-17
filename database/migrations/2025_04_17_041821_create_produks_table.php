<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksTable extends Migration
{
    public function up()
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->bigIncrements('Produkid');
            $table->string('NamaProduk', 255);
            $table->decimal('Harga', 10, 2);
            $table->integer('Stok');
            $table->date('Expired')->nullable();
            $table->unsignedBigInteger('Kategoriid');
            $table->unsignedBigInteger('Supplierid');
            $table->foreign('Kategoriid')->references('Kategoriid')->on('kategoris');
            $table->foreign('Supplierid')->references('Supplierid')->on('suppliers');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produks');
    }
}
