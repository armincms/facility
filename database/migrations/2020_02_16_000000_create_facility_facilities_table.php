<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacilityFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facility_facilities', function (Blueprint $table) {
            $table->bigIncrements('id');       
            $table->string('resource');
            $table->string('field')->default("Armincms\\Facility\\Nova\\Fields\\Boolean"); 
            $table->string('icon')->default('none'); 
            $table->auth();      
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
        Schema::dropIfExists('facility_facilities');
    }
}
