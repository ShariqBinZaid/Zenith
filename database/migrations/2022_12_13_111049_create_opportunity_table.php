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
        Schema::create('opportunity', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->longtext('message')->nullable();
            $table->integer('brand_id');
            $table->integer('unit_id');
            $table->integer('company_id');
            $table->longtext('url');
            $table->integer('package_id');
            $table->longtext('feedback')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('location')->nullable();
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('opportunity');
    }
};
