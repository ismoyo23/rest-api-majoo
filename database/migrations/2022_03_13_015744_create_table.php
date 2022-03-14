<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_kategori', function (Blueprint $table) {
            $table->integer('id_kategori', 60)->autoIncrement();
            $table->string('nama_kategori', 40);
            $table->timestamps();
        });

        Schema::create('table_suplier', function (Blueprint $table) {
            $table->integer('id_suplier', 20)->autoIncrement();
            $table->string('nama_suplier', 50);
            $table->integer('telp');
            $table->timestamps();
        });


        Schema::create('table_produk', function (Blueprint $table) {
            $table->integer('produk_id', 60)->autoIncrement();
            $table->integer('id_kategori');
            $table->string('name_produk', 60);
            $table->integer('harga');
            $table->string('image', 80);
            $table->text('diskripsi');
            $table->integer('id_suplier');
            $table->timestamps();

             $table->foreign('id_kategori')->references('id_kategori')->on('table_kategori')->onDelete('restrict')->onUpdate('cascade');;
             $table->foreign('id_suplier')->references('id_suplier')->on('table_suplier')->onDelete('restrict')->onUpdate('cascade');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('password', 60);
            $table->string('email', 50);
            $table->integer('telp');
            $table->string('alamat', 70);
            $table->timestamps();
        });

        Schema::create('table_pelanggan', function (Blueprint $table) {
            $table->integer('id_pelanggan', 60)->autoIncrement();
            $table->string('nama_pelanggan', 30)->nullable();
            $table->integer('no_pelanggan');
            $table->text('alamat')->nullable();;
            $table->timestamps();
        });



        Schema::create('table_penjualan', function (Blueprint $table) {
            $table->integer('id_penjualan')->autoIncrement();
            $table->integer('id_produk');
            $table->integer('id');
            $table->integer('id_pelanggan');
            $table->timestamps();

             $table->foreign('id_produk')->references('produk_id')->on('table_produk')->onDelete('restrict')->onUpdate('cascade');;
             $table->foreign('id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
             $table->foreign('id_pelanggan')->references('id_pelanggan')->on('table_pelanggan')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_product');
        Schema::dropIfExists('table_kategori');
        Schema::dropIfExists('table_suplier');
        Schema::dropIfExists('table_penjualan');
        Schema::dropIfExists('users');
        Schema::dropIfExists('table_pelanggan');
    }
}
