<?php

namespace App\Repositories\Attributes;

use App\Model\Attribute;
use App\Model\Option;

class EloquentAttributesRepository implements AttributesRepository{

    private $attribute;
    private $option;

    function  __construct(Attribute $attribute, Option $option){
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
        $this->option->where('attribute_id',$id)->delete();
        $data->delete();
        if($data)
            return $data;
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
        $data = $this->option->find($id);
        $data->delete();
        if($data)
            return $data;
    }
}