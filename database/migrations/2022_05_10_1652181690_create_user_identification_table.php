<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserIdentificationTable extends Migration
{
    public function up()
    {
        Schema::create('user_identification', function (Blueprint $table) {

            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable()->index();
            $table->string('name');
            $table->string('contact_no');
            $table->string('identity_no');
            $table->text('address');
            $table->text('identity_attachments')->nullable();
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('user_identification');
    }
}