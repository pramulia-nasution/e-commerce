<?php

namespace App\Repositories\Manufactures;

use App\Model\Manufacture;
use App\Model\Product;

class EloquentManufacturesRepository implements ManufacturesRepository{

    private $manufacture;
    private $product;

    function  __construct(Manufacture $manufacture, Product $product){
        $this->manufacture = $manufacture;
        $this->product = $product;
    }

    public function pagingAllMaufactures(){
        $manufactures = $this->manufacture->leftJoin('images_detail',function ($join){
            $join->on('images_detail.image_id','=','manufactures.image_id')
                ->where(function ($query){
                    $query->where('images_detail.image_type','THUMBNAIL')
                    ->where('images_detail.image_type', '!=', 'THUMBNAIL')
                    ->orWhere('images_detail.image_type', '=', 'ACTUAL');
                });
            })
            ->select('manufactures.id','manufactures.name','manufactures.slug','manufactures.url','images_detail.path');
        return $manufactures;
    }

    public function getAllManufactures(){
        $manufactures = $this->manufacture->select('id','name')->orderBy('name')->get();
        if($manufactures)
            return $manufactures;
    }

    public function insertManufacture($data){
        $newData = $this->manufacture->create([
            'name' => $data->name,
            'slug' => $data->name,
            'url'  => $data->url,
            'image_id'  => $data->image_id
        ]);
        return $newData;
    }

    public function editManufacture($id){
        $manufacture = $this->manufacture->leftJoin('images_detail',function ($join){
            $join->on('images_detail.image_id','=','manufactures.image_id')
                ->where(function ($query){
                    $query->where('images_detail.image_type','THUMBNAIL')
                    ->where('images_detail.image_type', '!=', 'THUMBNAIL')
                    ->orWhere('images_detail.image_type', '=', 'ACTUAL');
                });
            })
            ->select('manufactures.id','manufactures.name','manufactures.slug','manufactures.url','manufactures.image_id','images_detail.path')
            ->where('manufactures.id',$id)
            ->first();
        return $manufacture;
    }

    public function updateManufacture($data,$id){
        $update = $this->manufacture->find($id);
        $update->name = $data->name;
        $update->slug = $data->name;
        $update->url  = $data->url;
        $update->image_id  = $data->image_id;
        $update->save();
        return $update;
    }

    public function deleteManufacture($id){
        $product_check = $this->product->where('manufacture_id',$id)->get();
        if($product_check->count() > 0)
            return $product_check->count();
        $data = $this->manufacture->find($id);
        $data->delete();
        if($data)
            return 0;
    }
}