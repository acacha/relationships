<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePeopleTable
 */
class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('givenName');
            $table->string('surname');
            $table->string('surname1');
            $table->string('surname2');
            $table->date('birthdate');
            $table->integer('birthplace_id')->unsigned();
            $table->enum('gender',['Male','Female']);
            $table->enum('civil_status',['Soltero/a','Casado/a','Separado/a','Divorciado/a',['Viudo/a']]);
            $table->timestamps();
        });

        Schema::create('people_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('person_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();
            $table->unique(['person_id', 'user_id']);
            $table->foreign('person_id')->references('id')->on('people')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people');
        Schema::dropIfExists('people_user');
    }
}
