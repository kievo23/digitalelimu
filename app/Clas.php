<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clas extends Model
{
    protected $table = 'class';
    
    protected $fillable = [
        'id','name', 'main_id','description','activate'
    ];

    public function book(){
    	return $this->hasMany('App\Book','main_id');
    }
}
