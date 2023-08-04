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
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('transaction_id') ->unsigned()->index();
            $table->double('amount', 10,2);
            $table->double('used_wallet_amt', 10,2)->default(0);
            $table->double('sales_tax',10,2)->default(0);
            $table->string('currency',100);
            $table->string('payer_first_name',150);
            $table->string('payer_last_name',150);
            $table->string('payer_company',150);
            $table->string('payer_country',150);
            $table->string('payer_state',150);
            $table->string('payer_postal_code',150);
            $table->string('payer_address',500);
            $table->string('payer_city',150);
            $table->string('payer_phone',150);
            $table->string('payer_email',150);
            $table->tinyInteger('transaction_type')->comment('0->package, 1->milestone_project, 2->fixed_project, 3->hourly_project, 4->gig_order');
            $table->bigInteger('type_ref_id')->unsigned()->index()->comment('corresponding id according to transaction_type');
            
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
        Schema::dropIfExists('transaction_details');
    }
};
