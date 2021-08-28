<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ImagesDetail extends Model
{
    protected $table = 'images_detail';
    
    public function image(){
        return $this->belongsTo(Image::class);
    }
}
