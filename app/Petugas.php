<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    public $table = 'petugas';
	
    protected $fillable = ['kode_petugas','nama','jk','jabatan','telp','alamat'];
    public $timetamps = true;

    public function peminjaman(){
    	return $this->hasMany('App\Peminjaman', 'kode_petugas');
    }

    public function pengembalian(){
    	return $this->hasMany('App\Pengembalian','kode_petugas');
	}
}
