<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Edits extends Model
{
    protected $table = 'edits';
    
    protected $fillable = [
        'sub_id','amount','client_id'
    ];
    
     public function subscriptions()
    {
        return $this->belongsTo('App\Subscriptions', 'sub_id');
    }

    public function client(){
    	return $this->belongsTo('App\Clients','client_id');
    }
}
