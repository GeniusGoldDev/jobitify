<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAccountSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('user_account_settings', function (Blueprint $table) {

            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable()->index();
            $table->tinyInteger('show_image')->default('1')->comment('0-> image publically hidden');
            $table->double('hourly_rate',10,2)->default(0);
            $table->enum('verification',['pending','processed','approved','rejected'])->default('pending')->index();
            $table->mediumtext('verification_reject_reason')->nullable();
            $table->text('deactivation_reason')->nullable();
            $table->string('deactivation_description')->nullable();
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('user_account_settings');
    }
}