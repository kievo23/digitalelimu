<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //
    protected $table = 'book';
    
    protected $fillable = [
        'name','class_id','photo','lesson','description','category','activate'
    ];

    public function category()
    {
        return $this->belongsTo('App\Clas', 'class_id');
    }
}
