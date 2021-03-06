<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->id();
            $table->string('avatar')->default('default.jpg');
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->string('birthdate')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('contact_number')->nullable();
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('persons')->insert([
            [
                'firstname' => 'Francis',
                'lastname' => 'Alvarado'
            ],
            [
                'firstname' => 'Cynthia',
                'lastname' => 'Alvarado'
            ],
            [
                'firstname' => 'Angie',
                'lastname' => 'Bongo'
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persons');
    }
}
