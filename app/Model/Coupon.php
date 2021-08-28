<?php

namespace App\model;
use Illuminate\Support\Carbon;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $guarded = [];

    public function getExpiredDateAttribute(){
        return Carbon::parse($this->attributes['expired_date'])->translatedFormat('l, d F Y');
    }
}
