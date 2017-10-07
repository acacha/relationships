<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateContactsTable
 */
class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('value');
            $table->integer('contact_type_id')->unsigned();
            $table->unique(['value', 'contact_type_id']);
            $table->timestamps();
        });

        Schema::create('contact_person', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('person_id')->unsigned();
            $table->integer('contact_id')->unsigned();
            $table->tinyInteger('order');

            $table->unique(['person_id', 'contact_id']);

            $table->foreign('person_id')->references('id')->on('people')->onDelete('cascade');
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');

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
        Schema::dropIfExists('contact_person');
        Schema::dropIfExists('contacts');
    }
}
