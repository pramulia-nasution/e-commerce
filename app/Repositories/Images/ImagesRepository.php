<?php

namespace App\Repositories\Images;

interface ImagesRepository{
    public function getAllThumbnails();
    public function imageData($filename, $path, $width, $height);
    public function imageRecord($filename, $path, $width, $height, $type);
    public function detailImage($id);
    public function deleteImages($data);
    public function regenerate($data);
}