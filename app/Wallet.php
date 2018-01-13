<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    //
    protected $table = 'wallet';
    
    protected $fillable = [
        'id','client_id', 'amount'
    ];
}
