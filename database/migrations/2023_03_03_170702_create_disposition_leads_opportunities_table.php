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
        Schema::create('disposition_leads_opportunities', function (Blueprint $table) {
            $table->foreignId('disposition_id')->constrained('dispositions');
            $table->foreignId('user_id')->constrained('users');
            $table->morphs('object');
            $table->longText('feedback')->nullable();
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
        Schema::dropIfExists('disposition_leads_opportunities');
    }
};
