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
        Schema::create('package_subscribers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('subscriber_id')->unsigned()->nullable()->index();
            $table->bigInteger('package_id')->unsigned()->index()->nullable();
            $table->double('package_price',10,2)->default(0);
            $table->text('package_options')->nullable();
            $table->timestamp('package_expiry')->nullable();
            $table->enum('status', ['active', 'expired'])->default('active')->index();
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
        Schema::dropIfExists('package_subscribers');
    }
};
