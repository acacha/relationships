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
            $table->string('surname2')->nullable();
            $table->date('birthdate')->nullable();
            $table->integer('birthplace_id')->unsigned()->nullable();
            $table->enum('gender',['male','female'])->nullable();
            $table->enum('civil_status',['Soltero/a','Casado/a','Separado/a','Divorciado/a','Viudo/a'])->nullable();
            $table->string('notes')->nullable();
            $table->unique(['name','birthdate','gender']);
            $table->timestamps();
        });

        Schema::create('person_user', function (Blueprint $table) {
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
        Schema::dropIfExists('person_user');
        Schema::dropIfExists('people');
    }
}
