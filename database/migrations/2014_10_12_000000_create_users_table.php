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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('image')->default('user/man_avatar3.jpg');
            $table->integer('company_id');
            $table->integer('unit_id');
            $table->integer('team_id')->default('0');
<<<<<<< Updated upstream
            $table->integer('reporting_authority')->default('0');
=======
>>>>>>> Stashed changes
            $table->tinyInteger('is_leader')->default('0');
            $table->tinyInteger('depart_id')->default('0');
            $table->integer('created_by')->nullable();
            $table->string('phone')->nullable();
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
        Schema::dropIfExists('users');
    }
};
