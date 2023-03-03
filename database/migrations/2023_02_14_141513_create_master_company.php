<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_company', function (Blueprint $table) {
            $table->id('id_company');
            $table->string('company_name')->nullable();
            $table->string('alamat', 1000)->nullable();
            $table->integer('luas_tanah')->nullable();
            $table->integer('luas_bangunan')->nullable();
            $table->string('status_bangunan')->default(1);
            $table->integer('jumlah_karyawan_tetap')->nullable();
            $table->integer('jumlah_karyawan_kontrak')->nullable();
            $table->integer('jumlah_karyawan_outsource')->nullable();
            $table->string('nama_produk')->nullable();
            $table->string('proses_utama')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->boolean('status')->default(true);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('master_company');
    }
}
