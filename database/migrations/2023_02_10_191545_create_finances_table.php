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
        Schema::create('finances', function (Blueprint $table) {
            $table->id();
            $table->string('month');
            $table->string('year');
            $table->float('amount');
            $table->foreignId('currencyid')->constrained('currency');
            $table->longText('desc');
            $table->foreignId('userid')->constrained('users');
            $table->foreignId('unitid')->constrained('units');
            $table->foreignId('companyid')->constrained('companies');
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
        Schema::dropIfExists('finances');
    }
};
