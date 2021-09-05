<?php

namespace App\Repositories\Inventories;

interface InventoriesRepository{
    public function pagingAllInvontories();
    public function updateStock($request);
    public function history($product_id);
}