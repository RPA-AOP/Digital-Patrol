<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserGroupPrivileges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_group_privileges', function (Blueprint $table) {
            $table->id('id_user_group_privilege');
            $table->foreignId('id_user_group')
                ->nullable()
                ->constrained('user_groups', 'id_user_group')
                ->onDelete('cascade');
            $table->foreignId('id_menu')
                ->nullable()
                ->constrained('menus', 'id_menu')
                ->onDelete('cascade');
            $table->smallInteger('has_view');
            $table->smallInteger('has_create');
            $table->smallInteger('has_edit');
            $table->smallInteger('has_download');
            $table->smallInteger('has_delete');
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
        Schema::dropIfExists('user_group_privileges');
    }
}
