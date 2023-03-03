<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('patrol_schedule', function (Blueprint $table) {
      $table->id('patrol_schedule_id');
      $table->foreignId('id_company')->nullable()
        ->constrained('master_company', 'id_company')
        ->nullOnDelete();
      $table->boolean('status');
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
    Schema::dropIfExists('patrol_schedule');
  }
};
