<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    public $table = 'bukus';
	
    protected $fillable = ['kode_buku','judul','penulis','penerbit','tahun_terbit'];
    public $timetamps = true;

    public function rak(){
    	return $this->belongsTo('App\Rak', 'kode_buku');
    }

    public function pinjman(){
    	return $this->hasMany('App\Pinjaman', 'kode_buku');
    }

    public function pengembalian(){
    	return $this->hasMany('App\Pengembalian', 'kode_buku');
}
}
