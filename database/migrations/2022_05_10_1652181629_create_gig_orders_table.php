<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGigOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('gig_orders', function (Blueprint $table) {

            $table->id();
            $table->bigInteger('author_id')->unsigned()->nullable()->index();
            $table->bigInteger('gig_id')->unsigned()->nullable()->index();
            $table->string('plan_type');
            $table->double('plan_amount', 10, 2)->default(0);
            $table->text('gig_features')->nullable();
            $table->text('gig_addons')->nullable();
            $table->text('downloadable')->nullable();
            $table->tinyInteger('gig_delivery_days');
            $table->datetime('gig_start_time')->nullable();
            $table->tinyInteger('commission_type')->default(0)->comment('0-> free, 1-> fixed amount, 2-> percentage,  3-> commission tier fixed, 4-> commission tier per');
            $table->double('commission_amount',10,2)->default(0);
            $table->enum('status',['draft', 'hired', 'queued', 'completed', 'disputed', 'refunded', 'rejected'])->default('draft')->index();
            $table->softDeletes();
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('gig_orders');
    }
}