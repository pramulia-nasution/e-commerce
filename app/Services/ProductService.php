<?php
namespace App\Services;

use App\Repositories\Categories\CategoriesRepository;

class ProductService{

    function __construct(CategoriesRepository $category){
        $this->category = $category;
    }

    public function htmlCategory($parent_id = array()){
        $categories = $this->category->recursiveCategories();
        $parent_id = $parent_id;
        $option = '<ul class="list-group list-group-root well">';
        foreach ($categories as $parents) {
            if (in_array($parents->id, $parent_id))
                $checked = 'checked';
            else
                $checked = '';
            $option .= '<li href="#" class="list-group-item"><label style="width:100%">
            <input id="categories_' . $parents->id . '" ' . $checked . ' type="checkbox" class=" required_one categories sub_categories" name="categories[]" value="' . $parents->id . '">
          ' . $parents->name . '</label></li>';

            if (isset($parents->childs)) {
                $option .= '<ul class="list-group"><li class="list-group-item">';
                $option .= $this->childcat($parents->childs, $parent_id);
                $option .= '</li></ul>';
            }
        }
        $option .= '</ul>';
        return $option;
    }

    public function childcat($childs, $parent_id){
        $contents = '';
        foreach ($childs as $key => $child) {
            if (in_array($child->id, $parent_id))
                $checked = 'checked';
            else
                $checked = '';
            $contents .= '<label> <input id="categories_' . $child->id . '" parents_id="' . $child->parent_id . '"  type="checkbox" name="categories[]" class="required_one sub_categories categories sub_categories_' . $child->parent_id . '" value="' . $child->id . '" ' . $checked . '> ' . $child->name . '</label>';
            if (isset($child->childs)) {
                $contents .= '<ul class="list-group"><li class="list-group-item">';
                $contents .= $this->childcat($child->childs, $parent_id);
                $contents .= "</li></ul>";
            }
        }
        return $contents;
    }
}