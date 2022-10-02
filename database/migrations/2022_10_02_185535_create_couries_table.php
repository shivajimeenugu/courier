<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('couries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("billid")->references('id')->on('bills')->onDelete('cascade');;
            $table->bigInteger("cid")->unique();
            $table->date("cdate");
            $table->integer("amount");
            $table->string("cfrom");
            $table->string("cto");
            $table->string("csender");
            $table->string("creciver");
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
        Schema::dropIfExists('couries');
    }
}
