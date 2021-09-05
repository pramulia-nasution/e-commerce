<?php

namespace App\model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $guarded = [];

    public function product(){
        return $this->belongsTo(Product::class)->select('id','name');
    }

    public function getUpdatedAtAttribute(){
        return Carbon::parse($this->attributes['updated_at'])->translatedFormat('l, d F Y h:i:s A');
    }
}
