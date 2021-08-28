<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    
    public function images_detail(){
        return $this->hasMany(ImagesDetail::class);
    }
}
