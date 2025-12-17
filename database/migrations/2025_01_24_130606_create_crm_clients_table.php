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
        Schema::connection('mongodb')->create('crm_clients', function (Blueprint $table) {
            $table->id();
            $table->string('countryName')->nullable();
            $table->string('branchId')->nullable();
            $table->string('requestId')->nullable();
            $table->string('requestName')->nullable();
            $table->string('phoneNo')->nullable();
            $table->string('emialId')->nullable();
            $table->string('city')->nullable();
            $table->string('serviceCategory')->nullable();
            $table->string('requestLocation')->nullable();
            $table->string('requestSellCountry')->nullable();
            $table->string('assignOperationManager')->nullable();
            $table->string('jobTitle')->nullable();
            $table->integer('status')->default(1)->comment('1=Active, 0=Deactive');
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
        Schema::connection('mongodb')->dropIfExists('crm_clients');
    }
};
