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
        Schema::create('default_project_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('embedded_id')->nullable();
            $table->string('bot_icon')->nullable();
            $table->string('user_icon')->nullable();
            $table->string('bot_text_font_color')->nullable();
            $table->string('bot_text_font_size')->nullable();
            $table->string('bot_border_line_color')->nullable();
            $table->string('bot_background_color')->nullable();
            $table->string('instruction_logo')->nullable();
            $table->text('instruction_text')->nullable();
            $table->string('page_color')->nullable();
            $table->string('send_button_icon')->nullable();
            $table->string('bot_top_default_title')->nullable();
            $table->string('bot_placeholder_title')->nullable();
            $table->string('show_source_in_response')->nullable();
            $table->text('promote_template')->nullable();
            $table->float('temperature')->nullable();
            $table->string('custom_button_is_enable')->nullable();
            $table->string('custom_button_title')->nullable();
            $table->string('custom_button_link')->nullable();
            $table->string('custom_button_color')->nullable();
            $table->string('prompt_lang')->nullable();
            $table->string('number_of_source')->nullable();
            $table->string('language_model')->nullable();
            $table->string('script_expand_icon')->nullable();
            $table->string('script_collapsable_icon')->nullable();
            $table->string('script_collapsable_background_color')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('default_project_settings');
    }
};
