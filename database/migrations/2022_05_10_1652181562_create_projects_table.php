<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {

			$table->id();
			$table->bigInteger('author_id')->unsigned()->nullable()->index();
			$table->bigInteger('project_category')->unsigned()->nullable()->index();
			$table->string('project_title')->fullText();
			$table->string('slug')->index();
			$table->enum('project_type',['hourly','fixed'])->nullable()->index();
			$table->enum('project_payout_type',['fixed','both','milestone','hourly'])->nullable()->comment('fixed, milestones base, both options')->index();
			$table->text('attachments')->nullable();
			$table->text('project_description')->nullable()->fullText();
			$table->string('project_payment_mode',50)->nullable();
			$table->string('project_max_hours',50)->nullable();
			$table->double('project_min_price',10,2)->default(0)->index();
			$table->double('project_max_price',10,2)->default(0)->index();
			$table->string('project_country')->nullable();
			$table->string('country_zipcode')->nullable();
			$table->mediumtext('address')->nullable();
			$table->bigInteger('project_duration')->unsigned()->nullable()->index();
			$table->smallInteger('project_hiring_seller')->unsigned()->nullable();
			$table->smallInteger('project_expert_level')->unsigned()->nullable()->index();
			$table->smallInteger('project_location')->unsigned()->nullable()->index();
			$table->tinyInteger('is_featured')->default(0)->index();
			$table->datetime('featured_expiry')->nullable();
			$table->enum('status',['draft','pending','publish','hired','completed','refunded','cancelled'])->default('draft')->index();
			$table->softDeletes();
			$table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
}