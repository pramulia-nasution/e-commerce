<?php

namespace App\Repositories\Manufactures;

interface ManufacturesRepository{
    public function pagingAllMaufactures();
    public function getAllManufactures();
    public function insertManufacture($request);
    public function editManufacture($id);
    public function updateManufacture($request,$id);
    public function deleteManufacture($id);
}