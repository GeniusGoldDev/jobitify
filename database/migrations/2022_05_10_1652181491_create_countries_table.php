<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {

            $table->id();
            $table->string('name',100)->fullText();
            $table->string('short_code',50);
            $table->enum('status', ['active', 'deactive'])->default('active')->index();
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('countries');
    }
}