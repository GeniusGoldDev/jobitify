<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserEducationTable extends Migration
{
    public function up()
    {
        Schema::create('user_education', function (Blueprint $table) {

            $table->id();
            $table->bigInteger('profile_id')->unsigned()->nullable()->index();
            $table->string('deg_title');
            $table->string('deg_institue_name');
            $table->text('deg_description')->nullable();
            $table->timestamp('deg_start_date')->nullable();
            $table->timestamp('deg_end_date')->nullable();
            $table->tinyInteger('is_ongoing')->default('0');
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('user_education');
    }
}