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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('max_number_of_bot');
            $table->integer('max_number_of_response');
            $table->integer('max_number_of_click');
            $table->integer('max_number_of_mb');
            $table->float('price');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('plan_id');
            $table->integer('number_of_response')->default(0);
            $table->integer('number_of_click')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
