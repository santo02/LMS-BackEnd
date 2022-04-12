<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTheacersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('theacers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('NIP')->unique();
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('address');
            $table->string('username');
            $table->string('password');
            $table->string('role');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('theacers');
    }
}
