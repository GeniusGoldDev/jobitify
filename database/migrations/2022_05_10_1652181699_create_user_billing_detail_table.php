<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBillingDetailTable extends Migration
{
    public function up()
    {
        Schema::create('user_billing_detail', function (Blueprint $table) {

			$table->id();
			$table->bigInteger('profile_id')->unsigned()->index();
			$table->bigInteger('country_id')->unsigned()->nullable()->index();
			$table->bigInteger('state_id')->unsigned()->nullable()->index();
			$table->string('billing_first_name',100);
			$table->string('billing_last_name',100);
			$table->string('billing_company',100);
			$table->string('billing_phone',100);
			$table->string('billing_email',100);
			$table->string('billing_city',100);
			$table->string('billing_postal_code',100);
			$table->string('billing_address',500);
			$table->text('payout_settings')->nullable();
			$table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_billing_detail');
    }
}