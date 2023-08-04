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
        Schema::create('disputes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('created_by')->unsigned()->nullable()->index();
            $table->bigInteger('created_to')->unsigned()->nullable()->index();
            $table->bigInteger('proposal_id')->unsigned()->nullable()->index();
            $table->bigInteger('gig_order_id')->unsigned()->nullable()->index();
            $table->double('price',10,2)->default(0);
            $table->string('dispute_issue')->nullable();
            $table->text('dispute_detail')->nullable();
            $table->text('dispute_log')->nullable();
            $table->enum('resolved_by', ['admin','seller'])->default('seller');
            $table->enum('favour_to', ['seller','buyer'])->nullable();
            $table->enum('status', ['publish','declined','refunded','resolved','disputed','processing','cancelled'])->default('publish')->index();
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
        Schema::dropIfExists('disputes');
    }
};
