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
        Schema::create('dynamic_buttons', function (Blueprint $table) {
            $table->id();
            $table->string('button_title');
            $table->bigInteger('folder_id')->unsigned();
            $table->foreign('folder_id')->references('id')->on('folders')->onDelete('cascade');
            $table->string('button_url');
            $table->string('button_color');
            $table->float('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dynamic_buttons');
    }
};
