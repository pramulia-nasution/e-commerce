<?php

namespace App\Repositories\Attributes;

use App\Model\OptionProduct;
use App\Model\Attribute;
use App\Model\Option;

class EloquentAttributesRepository implements AttributesRepository{

    private $option_product;
    private $attribute;
    private $option;

    function  __construct(Attribute $attribute, Option $option, OptionProduct $option_product){
        $this->option_product = $option_product;
        $this->attribute = $attribute;
        $this->option = $option;
    }

    public function pagingAllAttributes(){
        $attributes = $this->attribute->with('options');
        return $attributes;
    }

    public function insertAttribute($data){
        $tempData = array_filter($data->value,function($obj){
            if($obj == null) 
                return false;
            return true;
        });
        $newData = $this->attribute->create([
            'name' => $data->name
        ]);
        $newArray = array();
        foreach($tempData as $item){
            array_push($newArray,[
                'attribute_id' => $newData->id,
                'value' => $item
            ]);
        }
        $newOption = $this->option->insert($newArray);
        return $newOption;
    }

    public function deleteAttribute($id){
        $data = $this->attribute->find($id);
        $option = $this->option->where('attribute_id',$id);
        foreach($option->get() as $item){
            $product_check = $this->option_product->where('option_id',$item->id)->get();
            if($product_check->count() > 0)
                return $product_check->count();
        }
        $option->delete();
        $data->delete();
        if($data)
            return 0;
    }

    public function ChangeAttributes($data){
        $newData = $this->option->updateOrCreate(
            ['id' => $data->id , 'attribute_id' => $data->attribute_id],[
            'value' => $data->value
        ]);
        if($newData)
            return $newData;
    }

    public function editValue($id){
        $data = $this->option->find($id);
        if($data)
            return $data;
    }

    public function deleteValue($id){
        $product_check = $this->option_product->where('option_id',$id)->get();
        if($product_check->count() > 0)
            return $product_check->count();
        $data = $this->option->find($id);
        $data->delete();
        if($data)
            return 0;
    }
}