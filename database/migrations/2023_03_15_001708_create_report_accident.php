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
		Schema::create('report_accident', function (Blueprint $table) {
            $table->id('report_accident_id');
            $table->string('title');
            $table->text('description');
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users', 'id_user')
                ->nullOnDelete();
            $table->foreignId('id_company')->nullable()
                ->constrained('master_company', 'id_company')
                ->nullOnDelete();

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
		Schema::dropIfExists('report_accident');
	}
};
