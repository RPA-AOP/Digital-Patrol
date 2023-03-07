<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_patroli_files', function (Blueprint $table) {
          $table->id('id_report_patrol_files');
          $table->foreignId('id_report_patrol_detail')->nullable()
            ->constrained('report_patrol_detail', 'id_report_patrol_detail')
            ->nullOnDelete();

          $table->foreignId('id_company')->nullable()
            ->constrained('master_company', 'id_company')
            ->nullOnDelete();

          $table->string('thumb');
          $table->string('type');
          $table->string('path');
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
        Schema::dropIfExists('report_patroli_files');
    }
};
