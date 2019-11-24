<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShortensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shortens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('eff_id')->unsigned()->nullable();
            $table->string('word', 20)->unique();
            $table->string('url', 140)->nullable();
            $table->timestamps();

            $table->index(['word', 'url']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shortens');
    }
}
