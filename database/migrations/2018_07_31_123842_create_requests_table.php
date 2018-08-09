<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("user_id")->references("id")->on("users");
            $table->point("source")->index();
            $table->point("destination");
            //$table->time("from_time");
            //$table->time("to_time");
            $table->unsignedInteger("at_time");

            //preferences
            $table->tinyInteger("empty_seats")->default(3);
            $table->tinyInteger("female_only")->default(0);

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
        Schema::dropIfExists('requests');
    }
}
