<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username')->unique()->nullable();
            $table->string('email')->unique();
            $table->boolean('enable')->default('0');
            $table->enum('roles', ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN', 'ROLE_CLIENTE', 'ROLE_GALANDER'])->default('ROLE_CLIENTE');
            $table->date('last_login')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
/*             $table->string('document_number')->unique()->nullable(); */
//campos agregados para relacionar con tablas existentes
            $table->integer('cliente_id')->unsigned()->nullable();
            $table->foreign('cliente_id')->references('id')->on('cliente')->onDelete('cascade');

            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
