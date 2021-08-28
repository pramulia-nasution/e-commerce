<?php

namespace App\Repositories\Attributes;

interface AttributesRepository{
    public function pagingAllAttributes();
    public function insertAttribute($request);
    public function deleteAttribute($id);
    public function ChangeAttributes($request);
    public function editValue($id);
    public function deleteValue($id);
}