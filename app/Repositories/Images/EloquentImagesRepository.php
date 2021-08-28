<?php 

namespace App\Repositories\Images;

use Auth;
use App\Model\Image;
use App\Model\ImagesDetail;

class EloquentImagesRepository implements ImagesRepository{

    private $image_detail;
    private $image;

    function  __construct(ImagesDetail $image_detail, Image $image){
        $this->image_detail = $image_detail;
        $this->image = $image;
    }

    public function getAllThumbnails(){
        $thumbnail = $this->image_detail->where('image_type','THUMBNAIL')->get();
        $actual    = $this->image_detail->where('image_type','ACTUAL')->get();
        return $actual->merge($thumbnail)->keyBy('image_id')->sortByDesc('id');
    }

    public function imagedata($filename, $path, $width, $height){
        $user_id = Auth::user() ? Auth::id() : null;
        $id = $this->image->insertGetId(
            ['name' => $filename, 'user_id' => $user_id]
        );
        $this->image_detail->insert([
            ['image_id' => $id, 'image_type' => '1', 'height' =>$height,'width' =>$width,'path' =>$path]
        ]); 
    }

    public function imageRecord($filename, $path, $width, $height,$type){
        $image = $this->image->where('name',$filename)->first();
        $this->image_detail->insert([
            ['image_id' => $image->id, 'image_type' => $type, 'height' =>$height,'width' =>$width,'path' =>$path]
        ]);
    }
}