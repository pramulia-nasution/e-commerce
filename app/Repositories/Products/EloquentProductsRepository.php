<?php

namespace App\Repositories\Products;

use App\Model\Product;
use App\Model\Category;
use App\Model\Deal;
use App\Model\OptionProduct;
use DB;
use Batch;

class EloquentProductsRepository implements ProductsRepository{


    function  __construct(Product $product, Category $category,Deal $deal){
        $this->product = $product;
        $this->category = $category;
        $this->deal = $deal;
    }

    public function pagingAllProducts(){
       $products =  $this->product->with(['categories','image' => function($query) {
            $query->select('image_id','path')->where('image_type','=','THUMBNAIL');
       }])
       ->select('id','name','model','image_id','type','status','weight','price');
        return $products;
    }

    public function insertProduct($data){
     DB::beginTransaction();
        try{
            $newData = $this->product->create([
                'name' => $data->name,
                'slug'  => $data->name,
                'description' => $data->description,
                'manufacture_id' => $data->manufacture_id,
                'price' => $data->price,
                'link'  => $data->link,
                'model' => $data->model,
                'image_id' => $data->image_id,
                'is_feature' => $data->is_feature,
                'status' => $data->status,
                'weight' => $data->weight,
                'type' => $data->attribute
            ]);
            $newData->categories()->attach($data->categories);
            if($data->attribute == '1')
                $newData->options()->attach($data->value_attribute);
            if($data->deal != '0'){
                $this->deal->create([
                    'product_id' => $newData->id,
                    'price' => $data->deal_price,
                    'type'  => $data->deal,
                    'start' => $data->start,
                    'end'   => $data->end
                ]);
            }
            DB::commit();
            return $newData;
        }catch(\Exception $e){
            DB::rollback();
        }
    }

    public function editProduct($id){
        $product =  $this->product->with(['categories','deal','options','image' => function($query) {
            $query->where('image_type','=','THUMBNAIL');
       }])
       ->find($id);
        return $product;
    }

    public function updateProdcut($data, $id){
        DB::beginTransaction();
        try{
            $update = $this->product->find($id);
            $update->name = $data->name;
            $update->slug  = $data->name;
            $update->description = $data->description;
            $update->manufacture_id = $data->manufacture_id;
            $update->price = $data->price;
            $update->link  = $data->link;
            $update->model = $data->model;
            $update->image_id = $data->image_id;
            $update->is_feature = $data->is_feature;
            $update->status = $data->status;
            $update->weight = $data->weight;
            $update->type = $data->attribute;
            $update->save();

            $update->categories()->sync($data->categories);
            if($data->attribute == '1')
                $update->options()->sync($data->value_attribute);
            else
                $update->options()->detach();
            if($data->deal == '0'){
                $deal = $this->deal->where('product_id',$id)->first();
                if($deal != null)
                    $this->deal->where('product_id',$id)->delete();
            }else{
                $this->deal->updateOrCreate(['product_id' => $id],[
                    'price' => $data->deal_price,
                    'type'  => $data->deal,
                    'start' => $data->start,
                    'end'   => $data->end
                ]);
            }
            DB::commit();
            return $update;
        }catch(\Exception $e){
            DB::rollback();
        }
    }

    public function deleteProduct($id){
        $data = $this->product->find($id);
        $data->categories()->detach();
        if($data->type == '1')
            $data->options()->detach();
        $deal = $this->deal->where('product_id',$id)->first();
        if($deal != null)
            $this->deal->where('product_id',$id)->delete();
        $data->delete();
        if($data)
            return $data;
    }

    public function getOptionProduct($id){
        $data = $this->product->find($id);
        if($data)
            return $data->options();
    }

    public function setValueOption($data){
        $option = new OptionProduct;
        $temp = array();
        $index = 'id';
        $length = count($data['id']);
        for($i = 0; $i < $length;$i++){
            array_push($temp,[
                'id' => $data['id'][$i],
                'option_price' => $data['value'][$i],
                'price_prefix' => $data['prefix'][$i]
            ]);
        }
        $update = Batch::update($option,$temp,$index);
        return $update;
    }
}