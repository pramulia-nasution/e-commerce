<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    protected $fillable = ['product_id','type','price','start','end'];
}
