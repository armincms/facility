<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacilityTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facility_translations', function (Blueprint $table) { 
            $table->bigIncrements('id');  
            $table->resource('label'); 
            $table->json('options'); 
            $table->string('help')->nullable();   
            $table->unsignedBigInteger('facility_id'); 

            $table->foreign('facility_id')->references('id')->on('facility_facilities')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facility_translations');
    }
}
