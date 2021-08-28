<?php

namespace App\Repositories\Categories;

interface CategoriesRepository{
    public function pagingAllCategories();
    public function insertCategory($request);
    public function editCategory($id);
    public function updateCategory($request,$id);
    public function deleteCategory($id);
    public function recursiveCategories();
}