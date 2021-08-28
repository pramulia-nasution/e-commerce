<?php

namespace App\Repositories\Categories;

use App\Model\Category;

class EloquentCategoriesRepository implements CategoriesRepository{

    private $category;

    function  __construct(Category $category){
        $this->category = $category;
    }

    public function pagingAllCategories(){
        $cateogories = $this->category->leftJoin('images_detail',function ($join){
            $join->on('images_detail.image_id','=','categories.image_id')
                ->where(function ($query){
                    $query->where('images_detail.image_type','THUMBNAIL')
                    ->where('images_detail.image_type', '!=', 'THUMBNAIL')
                    ->orWhere('images_detail.image_type', '=', 'ACTUAL');
                });
            })
            ->select('categories.id','categories.name','categories.slug','categories.status','images_detail.path')
            ->where('categories.id','!=','0');
        return $cateogories;
    }

    public function insertCategory($data){
        $newData = $this->category->create([
            'name' => $data->name,
            'slug' => $data->name,
            'status'  => $data->status,
            'image_id'  => $data->image_id,
            'parent_id' => $data->parent_id
        ]);
        return $newData;
    }

    public function editCategory($id){
        $category = $this->category->leftJoin('images_detail',function ($join){
            $join->on('images_detail.image_id','=','categories.image_id')
                ->where(function ($query){
                    $query->where('images_detail.image_type','THUMBNAIL')
                    ->where('images_detail.image_type', '!=', 'THUMBNAIL')
                    ->orWhere('images_detail.image_type', '=', 'ACTUAL');
                });
            })
            ->select('categories.id','categories.name','categories.slug','categories.status','categories.parent_id','categories.image_id','images_detail.path')
            ->where('categories.id',$id)
            ->first();
        return $category;
    }

    public function updateCategory($data,$id){
        $update = $this->category->find($id);
        $update->name = $data->name;
        $update->slug = $data->name;
        $update->status = $data->status;
        $update->image_id = $data->image_id;
        $update->parent_id = $data->parent_id;
        $update->save();
        if($data->status == '0'){
            $this->recursiveDisable($id);
        }
        return $update;
    }

    public function deleteCategory($id){
        $data = $this->category->find($id);
        $data->delete();
        if($data)
            return $data;
    }

    public function recursiveCategories($id = 0){
        $categories = $this->category->select('id','name','parent_id')
                        ->where('id','!=',$id)
                        ->get();
        $childs = array();
        foreach($categories as $category)
            $childs[$category->parent_id][] = $category;
        foreach($categories as $category) if(isset($childs[$category->id]))
            $category->childs = $childs[$category->id];
        
        if(!empty($childs[0])) 
            $tree = $childs[0];
        else
            $tree = $childs;     
        return  $tree;
    }

    private function recursiveDisable($id){
        $items = $this->category->where('parent_id',$id);
        if($items->count() > 0){
            $items->update(['status' => '0']);
            foreach($items->get() as $item)
                $this->recursiveDisable($item->id);
        }
    }
}