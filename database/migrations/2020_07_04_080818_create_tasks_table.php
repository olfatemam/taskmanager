<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('user_id')->constrained();
            $table->string('name');
            $table->dateTime('due');
            $table->foreignId('priority_id');
            $table->foreignId('status_id');
            $table->string('description')->nullable();
            
            $table->string('timezone');
            
            $table->boolean('reminder');
            $table->timestamps();
            $table->unique( array('user_id','name') );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
