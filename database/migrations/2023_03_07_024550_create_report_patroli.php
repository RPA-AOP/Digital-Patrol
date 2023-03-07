<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Uuid;

return new class extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('report_patrol', function (Blueprint $table) {
      $table->id('id_report_patrol');

      $table->foreignId('id_patrol_activity')->nullable()
        ->constrained('patrol_activity', 'id_patrol_activity')
        ->nullOnDelete();

      $table->foreignId('id_company')->nullable()
        ->constrained('master_company', 'id_company')
        ->nullOnDelete();

      $table->foreignId('patrol_schedule_shift_id')->nullable()
        ->constrained('patrol_schedule_shift', 'patrol_schedule_shift_id')
        ->nullOnDelete();

      $table->foreignId('level_1')->nullable()
        ->constrained('detail_patrol_config', 'id_detail_patrol_config')
        ->nullOnDelete();

      $table->foreignId('level_2')->nullable()
        ->constrained('detail_patrol_config', 'id_detail_patrol_config')
        ->nullOnDelete();

      $table->foreignId('level_3')->nullable()
        ->constrained('detail_patrol_config', 'id_detail_patrol_config')
        ->nullOnDelete();

      $table->foreignId('level_4')->nullable()
        ->constrained('detail_patrol_config', 'id_detail_patrol_config')
        ->nullOnDelete();

      $table->timestamp('checkin_time');
      $table->timestamp('checkout_time');

      $table->boolean('status');
      $table->uuid('sync_token')->default(Uuid::uuid4()->toString());
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
    Schema::dropIfExists('report_patroli');
  }
};
