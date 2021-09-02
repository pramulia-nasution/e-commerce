<?php

 namespace App\Services;

 use App\Repositories\Categories\CategoriesRepository;

 class CategoryService{

    function __construct(CategoriesRepository $category){
        $this->category = $category;
    }

    public function htmlCategory($id=0,$parent_id = 0){
        $categories = $this->category->recursiveCategories($id);
        $parent_id = $parent_id;
        $option = '<option value="0">Kategori Utama</option>';
        foreach($categories as $parent){
            $selected = '';
            if($parent->id > 0){
                if($parent->id == $parent_id)
                    $selected = 'selected';
                $option .= '<option value="'.$parent->id.'"  '.$selected.' >'.$parent->name.'</option>';
            }
            $i = 1;
            if(isset($parent->childs))
                $option .= $this->childCat($parent->childs,$i, $parent_id);
        }
        return $option;
    }

    private function childCat($childs,$i,$parent){
        $contents = '';
        foreach($childs as $key => $child){
            $dash = '';
            for($j=1; $j<=$i; $j++)
                $dash .=  '&nbsp; &nbsp; &nbsp;';
            if($child->id==$parent)
                $selected = 'selected';
            else
                $selected = '';
            $contents.='<option value="'.$child->id.'" '.$selected.'>'.$dash.$child->name.'</option>';
            if(isset($child->childs)){
                $k = $i+1;
                $contents.= $this->childCat($child->childs,$k,$parent);
            }
            elseif($i>0)
                $i=1;
        }
        return $contents;
    }

 }