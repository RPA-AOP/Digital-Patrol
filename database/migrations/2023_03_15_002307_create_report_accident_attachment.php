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
		Schema::create('report_accident_attachment', function (Blueprint $table) {
			$table->id('report_accident_attachment_id');
			$table->text('path');
			$table->string('extension');
			$table->foreignId('report_accident_id')
				->nullable()
				->constrained('report_accident', 'report_accident_id')
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
		Schema::dropIfExists('report_accident_attachment');
	}
};
