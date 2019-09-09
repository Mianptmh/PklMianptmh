<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengembaliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->String('kode_kembali');
            $table->Date('tanggal_kembali');
            $table->Date('jatuh_tempo');
            $table->Integer('denda_perhari');
            $table->Integer('jumlah_hari');
            $table->Integer('total_denda');
            $table->unsignedBigInteger('kode_petugas');
            $table->foreign('kode_petugas')->references('id')->on('petugas')->onDelete('cascade');
            $table->unsignedBigInteger('kode_anggota');
            $table->foreign('kode_anggota')->references('id')->on('anggotas')->onDelete('cascade');
            $table->unsignedBigInteger('kode_buku');
            $table->foreign('kode_buku')->references('id')->on('bukus')->onDelete('cascade');
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
        Schema::dropIfExists('pengembalians');
    }
}
