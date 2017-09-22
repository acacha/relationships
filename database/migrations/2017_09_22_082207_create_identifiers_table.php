<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateIdentifiersTable.
 */
class CreateIdentifiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('identifiers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('value');
            $table->integer('type')->unsigned();
            $table->foreign('type')->references('id')->on('identifier_types')->onDelete('cascade');
            $table->unique(['value', 'type']);
            $table->timestamps();
        });

        Schema::create('identifier_person', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('identifier_id')->unsigned();
            $table->integer('person_id')->unsigned();
            $table->timestamps();
            $table->unique(['identifier_id', 'person_id']);
            $table->foreign('identifier_id')->references('id')->on('identifiers')->onDelete('cascade');
            $table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('identifiers');
        Schema::dropIfExists('identifier_person');
    }
}
