<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->integer('mapping_id');
            $table->text('template_custom_id');
            $table->unique(['template_custom_id']);
            $table->text('preview_image');
            $table->text('background_image');
            $table->text('proof_image');
            $table->integer('font_id');
            $table->string('font_size', 10);
            $table->enum('text_position', ['left', 'center', 'right']);
            $table->text('font_color');

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
        Schema::dropIfExists('templates');
    }
}
