<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = ['name'];

    public function options(){
        return $this->hasMany(Option::class)->select('id','attribute_id','value');
    }
}
