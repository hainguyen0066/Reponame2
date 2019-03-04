<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableServers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'servers',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('game_server_id')->nullable();
                $table->enum('status', ['OPEN', 'CLOSE', 'DEV'])->default('DEV');
                $table->string('display_text')->nullable();
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('servers');
    }
}
