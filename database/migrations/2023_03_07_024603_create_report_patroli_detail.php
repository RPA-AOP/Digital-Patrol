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
        Schema::create('report_patrol_detail', function (Blueprint $table) {
            $table->id('id_report_patrol_detail');

            $table->foreignId('id_company')->nullable()
                ->constrained('master_company', 'id_company')
                ->nullOnDelete();

            $table->foreignId('id_report_patrol')->nullable()
                ->constrained('report_patrol', 'id_report_patrol')
                ->nullOnDelete();

            $table->foreignId('parent_level')->nullable() //parent level of object
            ->constrained('detail_patrol_config', 'id_detail_patrol_config')
                ->nullOnDelete();

            $table->foreignId('patrol_object_id')->nullable() //object should be lat level of patrol config
            ->constrained('detail_patrol_config', 'id_detail_patrol_config')
                ->nullOnDelete();

            $table->boolean('is_normal')->default(true);
            $table->string('patrol_note')->default('NORMAL');
            $table->boolean('is_accident_report')->default(false);
            $table->boolean('report_ga')->default(false);
            $table->boolean('quick_action')->default(false);
            $table->string('quick_action_note')->nullable();
            $table->string('sync_token');
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
        Schema::dropIfExists('report_patroli_detail');
    }
};
