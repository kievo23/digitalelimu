<?php
/**
 * Created by PhpStorm.
 * User: gits
 * Date: 5/23/17
 * Time: 5:37 PM
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    public $fillable = ['title','description'];

}