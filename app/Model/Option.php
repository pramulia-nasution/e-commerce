<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $guarded = [];

    public function attribute(){
        return $this->belongsTo(Attribute::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class);
    }
}
