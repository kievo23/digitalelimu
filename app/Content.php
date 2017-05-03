<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $table = 'content';
    
    protected $fillable = [
        'name','book_id','term','week','lesson','description','details','audio','video'
    ];
    
     public function book()
    {
        return $this->belongsTo('App\Book', 'book_id');
    }
}
