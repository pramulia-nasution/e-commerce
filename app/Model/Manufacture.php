<?php

namespace App\Model;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Manufacture extends Model
{
    protected $fillable = ['name','url','slug','image_id'];

    public function setSlugAttribute($value){
        $this->attributes['slug'] = Str::slug($value,'-');
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

}
