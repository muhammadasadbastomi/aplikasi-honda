<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSparepartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spareparts', function (Blueprint $table) {
            $table->id();
            $table->string('partNumber');
            $table->string('deskripsi');
            $table->string('partReference')->nullable();
            $table->string('kodeSupplier')->nullable();
            $table->string('kodeGroupSales')->nullable();
            $table->string('partStatus');
            $table->string('HET');
            $table->string('hargaPokok');
            $table->string('moqDk')->nullable();
            $table->string('moqDm')->nullable();
            $table->string('moqDb')->nullable();
            $table->string('partNumberType')->nullable();
            $table->string('partMoving')->nullable();
            $table->string('partSource')->nullable();
            $table->string('partCurrent')->nullable();
            $table->string('partType')->nullable();
            $table->string('partLifetime')->nullable();
            $table->string('partGroup')->nullable();
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
        Schema::dropIfExists('spareparts');
    }
}
