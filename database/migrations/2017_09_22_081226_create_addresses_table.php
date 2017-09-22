<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateAddressesTable
 */
class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('fullname');
            $table->string('type');
            $table->string('number');
            $table->string('floor');
            $table->string('floor_number');
            $table->string('postalCode');
            $table->string('location');
            $table->string('province');
            $table->string('country');
            $table->timestamps();
        });

        Schema::create('address_person', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('address_id')->unsigned();
            $table->integer('person_id')->unsigned();
            $table->timestamps();
            $table->unique(['address_id', 'person_id']);
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->foreign('person_id')->references('id')->on('people')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('address_person');
    }
}
