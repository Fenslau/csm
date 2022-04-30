<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLampasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lampas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('city')->index();
            $table->string('organization')->index();
            $table->string('department')->index();

            $table->string('lampa')->index();
            $table->string('condition');
            $table->string('rad_mode');
            $table->time('time_on');
            $table->time('time_off');
            $table->integer('duration');
            $table->integer('duration_all');

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
        Schema::dropIfExists('lampas');
    }
}
