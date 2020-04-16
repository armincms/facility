<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacilityFacilitateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facility_facilitate', function (Blueprint $table) { 
            $table->bigIncrements('id');  
            $table->morphs('facilitate');
            $table->unsignedBigInteger('facility_id'); 
            $table->string("value")->nullable();
            $table->integer('order')->default(0);

            $table
                ->foreign('facility_id')->references('id')->on('facility_facilities')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->index([
                'facility_id', 'facilitate_id', 'facilitate_type'
            ], 'facility_facilitate_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facility_facilitate'); 
    }
}
