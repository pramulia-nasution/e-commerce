<?php 

namespace App\Repositories\Images;

use Auth;
use App\Model\Image;
use Image as Images;
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

    public function detailImage($id){
        $images = $this->image_detail->where('image_id',$id)->get();
        if($images)
            return $images;
    }

    public function regenerate($data){
        $original_image = $this->image_detail->where(['image_id' => $data->image_id,'image_type' => 'ACTUAL'])->first()->path;
        $required_image = $this->image_detail->where('id',$data->id)->first()->path;
        if(file_exists($required_image))
            unlink($required_image);
        $total_string = strlen($required_image);
        $required_imag_path = substr($required_image, 0,21);
        $filename = substr($required_image, 21,$total_string);
        $destinationPath = public_path($required_imag_path);
        $saveimage = Images::make($original_image, array(
            'width' => $data->width,
            'height' => $data->height));
        $newName = $saveimage->save($destinationPath . $filename);
        $Path = $required_image;
        $destinationFile = public_path($Path);
        $size = getimagesize($destinationFile);
        list($width, $height, $type, $attr) = $size;
        $this->image_detail->where('id',$data->id)->update([
            'width' => $width,
            'height'=> $height,
        ]);
        return $newName;
    }

    public function deleteImages($data){
        $images = explode(",", $data->images);
        foreach($images as $image){
            $deleted = $this->image->find($image);
            $detail = $this->image_detail->where('image_id',$deleted->id);
            foreach($detail->get() as $images_deleted){
                if(file_exists($images_deleted->path))
                    unlink($images_deleted->path);
            }
            $detail->delete();
            $deleted->delete();
        }
        if($images)
            return $images;
    }
}