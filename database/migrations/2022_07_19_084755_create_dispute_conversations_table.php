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
        Schema::create('dispute_conversations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sender_id')->unsigned()->index();
            $table->bigInteger('dispute_id')->unsigned()->index();
            $table->bigInteger('message_id')->unsigned()->nullable()->index();
            $table->text('message')->nullable();
            $table->text('attachments')->nullable();
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
        Schema::dropIfExists('dispute_conversations');
    }
};
