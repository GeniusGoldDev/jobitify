<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalTimecardsTable extends Migration
{
    public function up()
    {
        Schema::create('proposal_timecards', function (Blueprint $table) {

            $table->id();
            $table->bigInteger('proposal_id')->unsigned()->nullable()->index();
            $table->string('title');
            $table->datetime('start_date')->index();
            $table->datetime('end_date')->index();
            $table->double('price',10,2)->default(0);
            $table->string('total_time', 50);
            $table->text('decline_reason')->nullable();
            $table->enum('status',['pending', 'queued', 'processing', 'completed', 'refunded', 'cancelled'])->default('pending')->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('proposal_timecards');
    }
}