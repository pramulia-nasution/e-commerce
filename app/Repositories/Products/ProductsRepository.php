<?php

namespace App\Repositories\Products;

interface ProductsRepository{
    public function pagingAllProducts();
    public function insertProduct($request);
    public function editProduct($id);
    public function updateProdcut($request,$id);
    public function deleteProduct($id);
    public function getOptionProduct($id);
    public function setValueOption($request);
    public function imagesProduct($id,$type);
    public function insertImage($data);
    public function deleteImages($id);
}