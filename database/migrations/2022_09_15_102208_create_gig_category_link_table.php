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
        Schema::create('gig_category_link', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gig_id')->index();
            $table->unsignedBigInteger('category_id')->index();
            $table->unsignedBigInteger('category_level')->index()->nullable(0);
            $table->timestamps();

            $table->foreign('gig_id')->references('id')->on('gigs');
            $table->foreign('category_id')->references('id')->on('gig_categories');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gig_category_link');
    }
};
