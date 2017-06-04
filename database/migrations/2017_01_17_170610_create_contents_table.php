<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();            
            $table->string('description')->nullable();       
            $table->integer('book_id')->unsigned();
            $table->foreign('book_id')->references('id')->on('book');
            $table->integer('term')->unsigned();
            $table->integer('week')->unsigned();
            $table->integer('lesson')->unsigned();            
            $table->text('details')->nullable();
            $table->string('audio')->unsigned(); 
            $table->string('video')->unsigned(); 
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
        Schema::dropIfExists('content');
    }
}
