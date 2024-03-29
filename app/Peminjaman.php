<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
     public $table = 'peminjamen';
	
    protected $fillable = ['kode_pinjam','tanggal_pinjam','tanggal_kembali','kode_petugas','kode_anggota','kode_buku'];
    public $timetamps = true;

    public function petugas(){
    	return $this->belongsTo('App\Petugas', 'kode_petugas');
    }

    public function anggota(){
    	return $this->belongsTo('App\Anggota', 'kode_anggota');
    }

    public function buku(){
    	return $this->belongsTo('App\Buku', 'kode_buku');
}
}