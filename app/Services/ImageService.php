<?php

 namespace App\Services;

use Carbon\Carbon;
use Image as Images;
use Illuminate\Support\Str;
use App\Repositories\Images\ImagesRepository;
use App\Repositories\Settings\SettingsRepository;

 class ImageService{

    function __construct(ImagesRepository $image, SettingsRepository $setting){
        $this->image = $image;
        $this->setting = $setting;
        $this->thumbnail = $this->setting->getThumbnailSize();
        $this->medium = $this->setting->getMediumSize();
        $this->large = $this->setting->getLargeSize();
    }

    public function makeImages($image){
        $time = Carbon::now();
        list($width, $height, $type, $attr) = getimagesize($image);
        $extension = $image->getClientOriginalExtension();
        $directory = date_format($time,'Y').'/'.date_format($time,'m');
        $filename = Str::random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
        $upload_success = $image->storeAs($directory, $filename, 'public');

        $path = 'images/media/'.$directory.'/'.$filename;
        $imageData = $this->image->imageData($filename, $path, $width, $height);
        switch(true){
            case($height >= $this->large[0] || $width >= $this->large[1]);
                $this->storeImage($path, $filename, $directory,$this->thumbnail,'THUMBNAIL');
                $this->storeImage($path, $filename, $directory,$this->medium, 'MEDIUM');
                $this->storeImage($path, $filename, $directory, $this->large, 'LARGE');
                break;
            case($height >= $this->medium[0] || $width >= $this->medium[1]);
                $this->storeImage($path, $filename, $directory,$this->thumbnail,'THUMBNAIL');
                $this->storeImage($path, $filename, $directory,$this->medium, 'MEDIUM');
                break;
            case($height >= $this->thumb[0] || $width >= $this->thumb[1]);
                $this->storeImage($path, $filename, $directory,$this->thumbnail,'THUMBNAIL');
                break;
        }
        return;
    }

    public function storeImage($path, $filename, $directory, $size, $type){
        $originalImage = $path;
        $destinationPath = public_path('images/media/'.$directory.'/');
        $newImage = Images::make($originalImage,[
            'width'     => $size[1],
            'height'    => $size[0]
        ]);
        $newImage->save($destinationPath . $type . time() . $filename);
        $path = 'images/media/' . $directory . '/' . $type . time() . $filename;
        $destinationFile = public_path($path);
        $size = getimagesize($destinationFile);
        list($width, $height, $types, $attr) = $size;
        $this->image->imageRecord($filename, $path, $width, $height, $type);
        return;
    }
 }