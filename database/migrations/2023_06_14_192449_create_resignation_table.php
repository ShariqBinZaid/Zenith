<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('resignation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('userid')->constrained('users');
            $table->foreignId('company_id')->constrained('companies');
            $table->longText('desc');
            $table->string('hr_status')->default('pending');
            $table->string('lead_status')->default('pending');
            $table->string('final_status')->default('pending');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resignation');
    }
};
