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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->string('year');
            $table->foreignId('userid')->constrained('users');
            $table->foreignId('type')->constrained('leave_types');
            $table->longText('reason')->nullable();
            $table->string('final_status')->default('pending');
            $table->string('lead_status')->default('pending');
            $table->string('hr_status')->default('pending');
            $table->integer('half_day')->default('0');
            $table->integer('unit_id');
            $table->integer('company_id');
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
        Schema::dropIfExists('leaves');
    }
};
