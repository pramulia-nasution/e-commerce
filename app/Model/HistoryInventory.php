<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class HistoryInventory extends Model
{
    protected $table = 'history_inventory';
    protected $guarded = [];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
