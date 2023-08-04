<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalTimecardDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('proposal_timecard_details', function (Blueprint $table) {

            $table->id();
            $table->bigInteger('timecard_id')->unsigned()->nullable()->index();
            $table->date('working_date');
            $table->string('working_time', 50);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('proposal_timecard_details');
    }
}