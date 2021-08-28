<?php

namespace App\Model;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','slug','image_id','status','parent_id'];

    public function setSlugAttribute($value){
        $this->attributes['slug'] = Str::slug($value,'-');
    }

    public function products(){
        return $this->belongsToMany(Product::class);
    }
}
