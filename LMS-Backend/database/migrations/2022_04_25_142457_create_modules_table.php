<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id('module_id');
            $table->foreignId('course_id')->references('id')->on('courses');
            $table->string('topic');
            $table->date('sesison_date');
            $table->string('content');
            $table->string('week');
            $table->string('sesion');
            $table->string('file');
            $table->string('theachers_id'); 
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
        Schema::dropIfExists('modules');
    }
}
