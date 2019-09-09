<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    public $table = 'raks';
	
    protected $fillable = ['kode_rak','nama_rak','kode_buku'];
    public $timetamps = true;

    public function buku(){
    	return $this->hasMany('App\Buku', 'kode_buku');
    }
}

