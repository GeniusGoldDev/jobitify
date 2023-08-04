<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkillsTable extends Migration
{
    public function up()
    {
        Schema::create('skills', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->string('name')->fullText();
            $table->text('image')->nullable();
            $table->string('slug')->index();;
            $table->text('description')->nullable()->fullText();
            $table->enum('status', ['active', 'deactive'])->default('active')->index();
            $table->softDeletes();
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('skills');
    }
}