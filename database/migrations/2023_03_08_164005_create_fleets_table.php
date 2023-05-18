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
        Schema::create('fleets', function (Blueprint $table) {
            $table->id();
            $table->string('car_name');
            $table->string('cc');
            $table->string('model');
            $table->string('km');
            $table->string('chassis_number')->nullable();
            $table->string('engine_number')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->integer('company_id');
            $table->string('car_number');
            $table->string('vendor');
            $table->string('vendor_number');
            $table->string('video')->nullable();
            $table->float('rent');
            $table->string('assign_date')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('fleets');
    }
};
