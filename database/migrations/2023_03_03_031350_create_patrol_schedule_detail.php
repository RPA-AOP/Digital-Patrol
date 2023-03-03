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
    Schema::create('patrol_schedule_detail', function (Blueprint $table) {
      $table->id('patrol_schedule_detail');
      $table->foreignId('patrol_schedule_id')->nullable()
        ->constrained('patrol_schedule', 'patrol_schedule_id')
        ->nullOnDelete();
      $table->foreignId('patrol_schedule_shift_id')->nullable()
        ->constrained('patrol_schedule_shift', 'patrol_schedule_shift_id')
        ->nullOnDelete();
      $table->foreignId('id_user')->nullable()
        ->constrained('users', 'id_user')
        ->nullOnDelete();
      $table->date('patrol_date');
      $table->boolean('status')->default(true);
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
    Schema::dropIfExists('patrol_schedule_detail');
  }
};
