<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalMilestonesTable extends Migration
{
    public function up()
    {
        Schema::create('proposal_milestones', function (Blueprint $table) {

            $table->id();
            $table->bigInteger('proposal_id')->unsigned()->nullable()->index();
            $table->string('title');
            $table->double('price',10,2)->default(0);
            $table->text('description')->nullable();
            $table->text('decline_reason')->nullable();
            $table->enum('status',['pending', 'processing', 'processed', 'queued', 'completed', 'refunded',  'cancelled'])->default('pending')->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('proposal_milestones');
    }
}