<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //
    protected $table = 'book';
    
    protected $fillable = [
        'name','class_id','photo','bookpdf','lesson','description','category','activate','booktype'
    ];

    public function category()
    {
        return $this->belongsTo('App\Clas', 'class_id');
    }
}
