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
        Schema::create('gig_order_activities', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sender_id')->unsigned()->index();
            $table->bigInteger('receiver_id')->unsigned()->index();
            $table->bigInteger('gig_id')->unsigned()->index();
            $table->bigInteger('order_id')->unsigned()->index();
            $table->enum('type', ['revision', 'final'])->default('revision')->index();
            $table->text('attachments')->nullable();
            $table->text('description');
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
        Schema::dropIfExists('gig_order_activities');
    }
};
