<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
	public $table = 'anggotas';
	
    protected $fillable = ['kode_anggota','nama','jk','jurusan','alamat'];
    public $timetamps = true;

    public function peminjaman(){
    	return $this->hasMany('App\Peminjaman', 'kode_anggota');
    }

    public function pengembalian(){
    	return $this->hasMany('App\Pengembalian', 'kode_anggota');
    }
}
