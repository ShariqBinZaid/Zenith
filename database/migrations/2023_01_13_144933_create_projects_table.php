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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('package_id');
            $table->integer('customer_id');
            $table->integer('brand_id');
            $table->integer('unit_id');
            $table->longtext('desc')->nullable;
            $table->string('priority')->default('normal');
            $table->integer('project_type');
            $table->integer('added_by');
            $table->morphs('converted');
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('projects');
    }
};
