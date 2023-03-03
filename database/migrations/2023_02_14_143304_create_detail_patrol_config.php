<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPatrolConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_patrol_config', function (Blueprint $table) {
            $table->id('id_detail_patrol_config');
            $table->foreignId('id_company')
                ->constrained('master_company', 'id_company')
                ->nullOnDelete(); // make data easier to filtering
            $table->foreignId('id_patrol_config')
                ->constrained('patrol_config', 'id_patrol_config')
                ->nullOnDelete();
            $table->string('code');
            $table->string('name');// ZONE NAME/CHECKPOINT NAME/OBJECT NAME/PLANT NAME OR ETC
            $table->integer('level')->default(1);
            $table->string('level_name')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('identification_key')->nullable(); // unique identification key
            $table->string('status')->default(1);// ZONE NAME/CHECKPOINT NAME/OBJECT NAME/PLANT NAME OR ETC
            $table->integer('last_level')->default(false); //last level == enable reporting
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
        Schema::dropIfExists('detail_patrol_config');
    }
}
