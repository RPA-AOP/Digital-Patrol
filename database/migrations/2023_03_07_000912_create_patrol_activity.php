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
    Schema::create('patrol_activity', function (Blueprint $table) {
      $table->id('id_patrol_activity');
      $table->foreignId('id_company')->nullable()
        ->constrained('master_company', 'id_company')
        ->nullOnDelete();

      $table->foreignId('patrol_schedule_shift_id')->nullable()
        ->constrained('patrol_schedule_shift', 'patrol_schedule_shift_id')
        ->nullOnDelete();

      $table->foreignId('id_user')
        ->nullable()
        ->constrained('users', 'id_user')
        ->nullOnDelete();

      $table->boolean('in_shift')
        ->default(false);

      $table->date('patrol_date');
      $table->timestamp('patrol_start_time');
      $table->timestamp('patrol_end_time')->nullable();
      $table->smallInteger('status')->default(0); // 0 -> on progress; 1 -> done
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
    Schema::dropIfExists('patrol_activity');
  }
};
