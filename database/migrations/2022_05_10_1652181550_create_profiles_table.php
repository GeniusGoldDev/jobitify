<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {

			$table->id();
			$table->bigInteger('user_id')->unsigned()->nullable()->index();
			$table->bigInteger('role_id')->unsigned()->nullable()->index();
			$table->string('first_name',150)->fullText();
			$table->string('last_name',150)->fullText();
			$table->string('slug')->index();
			$table->string('image')->nullable();
			$table->string('tagline')->nullable()->fullText();
			$table->text('description')->nullable()->fullText();
			$table->string('country')->nullable();
			$table->text('address')->nullable();
			$table->string('zipcode',200)->nullable();
			$table->string('seller_type')->nullable()->fullText();
			$table->enum('english_level',['basic', 'conversational', 'fluent', 'native', 'professional'])->nullable();
			$table->tinyInteger('is_featured')->default(0)->index();
			$table->datetime('featured_expiry')->nullable();
			$table->softDeletes();
			$table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}