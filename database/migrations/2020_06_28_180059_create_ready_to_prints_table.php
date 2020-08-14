<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReadyToPrintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ready_to_prints', function (Blueprint $table) {
            $table->id();
            $table->text('image');
            $table->text('brand_name');
            $table->text('template_id');
            $table->text('order_id');
            $table->text('used_font_map');
            $table->int('pdf_generated');
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
        Schema::dropIfExists('ready_to_prints');
    }
}
