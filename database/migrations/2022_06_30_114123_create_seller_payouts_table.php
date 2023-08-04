<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seller_payouts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('seller_id')->unsigned()->index();
            $table->bigInteger('transaction_id')->unsigned()->index();
            $table->bigInteger('project_id')->unsigned()->index()->nullable();
            $table->bigInteger('gig_id')->unsigned()->index()->nullable();
            $table->double('seller_amount',10,2);
            $table->double('admin_commission',10,2)->default('0');
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
        Schema::dropIfExists('seller_payouts');
    }
};
