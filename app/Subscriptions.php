<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriptions extends Model
{
    //
    protected $table = 'subscriptions';
    
    protected $fillable = [
        'id','client_id', 'book_id','amount'
    ];
    public function book()
    {
        return $this->belongsTo('App\Book', 'book_id');
    }
    
    public function client()
    {
        return $this->belongsTo('App\Clients', 'client_id');
    }
}
