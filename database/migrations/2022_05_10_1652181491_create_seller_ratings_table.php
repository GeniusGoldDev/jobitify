<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerRatingsTable extends Migration
{
    public function up()
    {
        Schema::create('seller_ratings', function (Blueprint $table) {

            $table->id();
            $table->bigInteger('seller_id')->unsigned()->index();
            
            $table->bigInteger('corresponding_id')->unsigned()->index();
            $table->enum('type',['proposal','gig_order'])->index();
            $table->tinyInteger('rating')->nullable();
            $table->string('rating_title');
            $table->mediumtext('rating_description')->nullable();
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('seller_ratings');
    }
}