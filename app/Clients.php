<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    //
    protected $table = 'clients';
    
    protected $fillable = [
        'id','phone', 'password','accesstoken','email'
    ];
}
