<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    //
    protected $table = 'payments';
    
    protected $fillable = [
        'id','transcode', 'category','providerRefId','source','destination','accountNumber','amount','status','jsond'
    ];
}
