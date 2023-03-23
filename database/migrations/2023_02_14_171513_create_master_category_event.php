<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterCategoryEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_category_event', function (Blueprint $table) {
            $table->id('id_category_event');
            $table->foreignId('id_category')
                ->constrained('master_category', 'id_category')
                ->nullOnDelete();
            $table->foreignId('id_company')
                ->constrained('master_company', 'id_company')
                ->nullOnDelete();
            $table->string('category_event')->nullable();
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('master_category_event');
    }
}
