<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps('created_at');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->float('coefLow', 8);
            $table->float('coefHigh', 8);
            $table->string('projects');
        });

        Schema::create('timesheet', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps('created_at');
            $table->string('date');
            $table->boolean('isWorking')->default(false);
            $table->integer('project_id');
            $table->integer('ticket_number');
            $table->integer('worktime');
            $table->boolean('isPodioUpdated');
            $table->float('worktimeWithCoef');
        });

        Schema::table('timesheet', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('user')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
        Schema::dropIfExists('timesheet');
    }
};
