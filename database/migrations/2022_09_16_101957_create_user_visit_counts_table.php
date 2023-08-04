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
        Schema::create('user_visit_counts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('corresponding_id')->index();
            $table->enum('visit_type',['profile','gig','project'])->index();
            $table->text('browser_info')->nullable();
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
        Schema::dropIfExists('user_visit_counts');
    }
};
