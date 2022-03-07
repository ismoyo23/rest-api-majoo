<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Gloing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // users
        Schema::create('users', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->tinyInteger('is_admin');
            $table->string('mobile_number', 100);
            $table->string('email', 100);
            $table->string('username', 100);
            $table->enum('auth_type', ['default']);
            $table->string('password', 100);
            $table->string('remember_token', 200);
            $table->enum('status', ['GRANTED','LOCKED','FROZEN','BANNED']);
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
        });

        

        Schema::create('permission', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('name', 255);
            $table->string('guard_name', 255);
            $table->timestamps();
           
            $table->softDeletes();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by');
        });


        Schema::create('activities', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->bigInteger('permission_id')->unsigned();
            $table->string('name', 100);
            $table->string('email', 100);
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by');

            $table->foreign('permission_id')->references('id')->on('permission')->onDelete('restrict')->onUpdate('cascade');
        });


        Schema::create('user_has_activities', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('activity_id')->unsigned();
            $table->string('name',255);
            $table->enum('access_type', ['WEB', 'MOBILE']);
            $table->string('ip_address',255);
            $table->string('latitude',255);
            $table->string('longitude',255);
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('activity_id')->references('id')->on('activities')->onDelete('restrict')->onUpdate('cascade');
        });



        Schema::create('tags', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('name', 100);
            $table->string('slug', 100);
            $table->string('color', 100);
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by');
        });

        Schema::create('user_has_tag', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('tag_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('restrict')->onUpdate('cascade');
        });

        Schema::create('keywords', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->string('name', 255);
            $table->string('slug', 255);
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by');
        });

        Schema::create('users_has_keyword', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('keyword')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
        });

        Schema::create('profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->bigInteger('user_id')->unsigned();
            $table->string('full_name', 255);
            $table->enum('gender', ['MALE', 'FEMALE']);
            $table->date('birth_date');
            $table->string('bio', 255);
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
        });

        Schema::create('units', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->string('name', 255);
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by');
        });

        Schema::create('files', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('full_name', 255);
            $table->string('type', 255);
            $table->string('size', 255);
            $table->string('location', 255);
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by');
        });


        Schema::create('user_has_files', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('file_id')->unsigned();
            $table->string('full_name', 255);
            $table->enum('gender', ['MALE', 'FEMALE']);
            $table->date('birth_date');
            $table->string('bio', 255);
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('file_id')->references('id')->on('files')->onDelete('restrict')->onUpdate('cascade');
        });

        Schema::create('profile_has_files', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('profile_id')->unsigned();
            $table->bigInteger('file_id')->unsigned();
            $table->tinyInteger('is_profile_picture');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by');

            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('file_id')->references('id')->on('files')->onDelete('restrict')->onUpdate('cascade');
        });


        


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}