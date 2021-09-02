<?php

namespace App\Repositories\Inventories;

use App\Model\Inventory;

class EloquentInventoriesRepository implements InventoriesRepository{

    private $inventory;

    function  __construct(Inventory $inventory){
        $this->inventory = $inventory;
    }

    public function pagingAllInvontories(){
           $inventories = $this->inventory->with('product');
           return $inventories;
    }

}