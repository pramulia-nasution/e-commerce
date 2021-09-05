<?php

namespace App\Repositories\Inventories;

use App\Model\Inventory;
use App\Model\HistoryInventory;

class EloquentInventoriesRepository implements InventoriesRepository{


    function  __construct(Inventory $inventory, HistoryInventory $history){
        $this->inventory = $inventory;
        $this->history = $history;
    }

    public function pagingAllInvontories(){
           $inventories = $this->inventory->with('product');
           return $inventories;
    }

    public function updateStock($data){
        $product = $this->inventory->where('product_id',$data->product_id);
        if($product->first() != null){
            if($data->type == 'in')
                $product->increment('stock',$data->stock);
            else
                $product->decrement('stock',$data->stock);
            $history = $this->history->create([
                'product_id' => $data->product_id,
                'value' => $data->stock,
                'type' => $data->type
            ]);
            if($history)
                return $history;   
        }
    }

    public function history($id){
        $data = $this->history_inventory->with('product')->get();
    }

}