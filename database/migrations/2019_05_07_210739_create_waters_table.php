<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWatersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('current_id')->default(1);
            $table->integer('tide_id')->default(1);
            $table->string('name');
            $table->text('description');
            $table->text('contact');
            $table->string('location');
            $table->integer('deep');
            $table->integer('currentV')->nullable();
            $table->decimal('center_lat', 18, 14);
            $table->decimal('center_lng', 18, 14);
            $table->json('bounds');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('waters');
    }
}
