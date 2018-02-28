<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    //
    protected $table = 'publishers';
    
    protected $fillable = [
        'id','publisher'
    ];
}
