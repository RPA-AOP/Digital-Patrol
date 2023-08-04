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
        Schema::table('report_patrol_detail', function (Blueprint $table) {
            $table->boolean('action_status')->default(false);
            $table->text('action_note')->nullable();
            $table->string('action_proof')->nullable();
            $table->dateTime('action_at')->nullable();
            $table->timestamp('action_reported_at')->default(now());
            $table->foreignId('action_user')->nullable()
                ->constrained('users', 'id_user')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('report_patrol_detail', function (Blueprint $table) {
            $table->dropColumn('action_status');
            $table->dropColumn('action_note');
            $table->dropColumn('action_proof');
            $table->dropColumn('action_user');
        });
    }
};
