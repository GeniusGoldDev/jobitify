<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gig_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gig_id')->nullable()->index();
            $table->string('title')->fullText();
            $table->text('description')->nullable();
            $table->double('price',10,2)->default(0);
            $table->tinyInteger('delivery_time');
            $table->tinyInteger('is_featured')->default('0');
            $table->text('options')->nullable();
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
        Schema::dropIfExists('gig_plans');
    }
};
