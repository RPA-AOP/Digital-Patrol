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
    Schema::create('patrol_schedule_shift', function (Blueprint $table) {
      $table->id('patrol_schedule_shift_id');
      $table->string('shift_name');
      $table->string('shift_code')->unique();
      $table->time('start_hour')->nullable();
      $table->time('end_hour')->nullable();
      $table->foreignId('id_company')->nullable()
        ->constrained('master_company', 'id_company')
        ->nullOnDelete();
      $table->boolean('status')->default('false');
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
    Schema::dropIfExists('patrol_schedule_shift');
  }
};
