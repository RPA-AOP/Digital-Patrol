<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Menus extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('menus', function (Blueprint $table) {
      $table->id('id_menu');
      $table->integer('parent_id')->nullable();
      $table->string('name');
      $table->string('icon')->nullable();
      $table->string('type')->default('menu');
      $table->string('slug')->nullable();
      $table->string('url', 1000)->default('#');
      $table->smallInteger('is_hidden');
      $table->smallInteger('sort');
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
    Schema::dropIfExists('menus');
  }
}
