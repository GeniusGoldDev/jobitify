<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalsTable extends Migration
{
    public function up()
    {
        Schema::create('proposals', function (Blueprint $table) {

            $table->id();
            $table->bigInteger('author_id')->unsigned()->nullable()->index();
            $table->bigInteger('project_id')->unsigned()->nullable()->index();
            $table->double('proposal_amount', 10, 2)->default(0);
            $table->enum('payout_type',['fixed','milestone', 'hourly']);
            $table->text('special_comments');
            $table->string('payment_mode',50)->nullable();
            $table->tinyInteger('commission_type')->default(0)->comment('0-> free, 1-> fixed amount, 2-> percentage,  3-> commission tier fixed, 4-> commission tier per');
            $table->double('commission_amount',10,2)->default(0);
            $table->tinyInteger('resubmit')->default(0)->comment('1-> re-submission request by buyer');
            $table->enum('status',['draft','pending', 'publish', 'declined', 'hired', 'queued', 'completed', 'disputed', 'refunded', 'rejected'])->default('draft')->index();
            $table->text('decline_reason')->nullable();
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('proposals');
    }
}