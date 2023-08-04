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
        Schema::create('escrow_disburse_methods', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('seller_id')->unsigned()->index();
            $table->bigInteger('project_id')->unsigned()->index();
            $table->bigInteger('disburse_methods_id')->unsigned()->index();
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
        Schema::dropIfExists('escrow_disburse_methods');
    }
};
