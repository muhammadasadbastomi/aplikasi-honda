<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penjualan_id')->nullable();
            $table->foreign('penjualan_id')->references('id')->on('penjualans')->onDelete('cascade');
            $table->unsignedBigInteger('sparepart_id');
            $table->foreign('sparepart_id')->references('id')->on('spareparts')->onDelete('restrict');
            $table->string('jumlah');
            $table->string('hargaJual');
            $table->string('diskon')->nullable();
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
        Schema::dropIfExists('penjualan_details');
    }
}
