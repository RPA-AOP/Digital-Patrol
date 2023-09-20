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
        Schema::table('patrol_config', function($table) {
            $table->boolean('random_checkpoint')->default(false);
            $table->integer('random_checkpoint_percentage')->default(80);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patrol_config', function($table) {
            $table->dropColumn('random_checkpoint');
            $table->dropColumn('random_checkpoint_percentage');
        });
    }
};
