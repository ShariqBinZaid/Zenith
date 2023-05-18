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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->integer('month');
            $table->integer('year');
            $table->float('deduction')->default(0);
            $table->float('tax')->default(0);
            $table->float('amount');
            $table->integer('deduction_days');
            $table->integer('earned_days');
            $table->integer('half_days')->default(0);
            $table->integer('total_days');
            $table->float('salary')->default(0);
            $table->integer('company_id');
            $table->integer('unit_id')->default(0);
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('payrolls');
    }
};
