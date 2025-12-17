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
        Schema::connection('mongodb')->create('crm_leads', function (Blueprint $table) {
            $table->id();
            $table->string('country')->nullable();
            $table->string('branch')->nullable();
            $table->string('request_id')->nullable();
            $table->string('requester_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('city')->nullable();
            $table->string('service_category')->nullable();
            $table->string('requester_location')->nullable();
            $table->string('requester_sell_in_country')->nullable();
            $table->string('assign_to_sales')->nullable();
            $table->string('comments')->nullable();
            $table->string('note_from_requester')->nullable();
            $table->string('job_title')->nullable();
            $table->enum('status',["1","0"])->default(0);
            $table->string('admin_id')->nullable();
            $table->string('branch_id')->nullable();
            $table->string('team_id')->nullable();
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
        Schema::connection('mongodb')->dropIfExists('crm_leads');
    }
};
