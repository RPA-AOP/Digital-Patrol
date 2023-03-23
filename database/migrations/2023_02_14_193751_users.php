<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('username');
            $table->string('password', 1000);
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('npk')->nullable();
            $table->string('image')->nullable();
            $table->string('phone')->nullable();
            $table->foreignId('id_company')->nullable()
                ->constrained('master_company', 'id_company')
                ->nullOnDelete();
            $table->foreignId('id_user_group')->nullable()
                ->constrained('user_groups', 'id_user_group')->onDelete('cascade');
            $table->foreignId('area')->nullable()
                ->constrained('detail_patrol_config', 'id_detail_patrol_config')
                ->nullOnDelete();
            $table->smallInteger('status')->default(0);
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
        Schema::dropIfExists('users');

    }
}
