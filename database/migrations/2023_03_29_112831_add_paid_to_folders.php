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
        Schema::table('folders', function (Blueprint $table) {
            $table->string('bot_icon')->nullable();
            $table->string('user_icon')->nullable();
            $table->string('bot_text_font_color')->nullable();
            $table->string('bot_text_font_size')->nullable();
            $table->string('bot_border_line_color')->nullable();
            $table->string('bot_background_color')->nullable();
            $table->string('instruction_logo')->nullable();
            $table->text('instruction_text')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('folders', function (Blueprint $table) {
            //
        });
    }
};
