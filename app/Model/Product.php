<?php

namespace App\Model;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name','slug','description','image_id','manufacture_id','kind','type','status','is_feature','weight','price','link','model'];

    public function setSlugAttribute($value){
        $this->attributes['slug'] = Str::slug($value,'-');
    }

    public function image(){
        return $this->hasOne(ImagesDetail::class,'image_id','image_id');
    }

    public function manufacture(){
        return $this->belongsTo(Manufacture::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class)->select('categories.id','name','parent_id');
    }

    public function options(){
        return $this->belongsToMany(Option::class)->withPivot('id','option_price','price_prefix');
    }

    public function deal(){
        return $this->hasOne(Deal::class);
    }

    public function inventory(){
        return $this->hasOne(Inventory::class);
    }
}
