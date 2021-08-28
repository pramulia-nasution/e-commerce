<?php

namespace App\Repositories\Coupons;

use App\Model\Coupon;

class EloquentCouponsRepository implements CouponsRepository{

    public $coupon;
    function  __construct(Coupon $coupon){
        $this->coupon = $coupon;
    }

    public function pagingAllCoupons(){
        $coupons = $this->coupon->select('id','code','coupon_total','type','amount','description','expired_date');
        return $coupons;
    }

    public function insertCoupon($data){
        $newData = $this->coupon->create([
            'code' => $data->code,
            'description' => $data->description,
            'coupon_total' => $data->coupon_total,
            'expired_date' => $data->expired_date,
            'type' => $data->type,
            'amount' => $data->amount,
            'maximum_amount' => $data->max_amount,
            'minimum_amount' => $data->min_amount,
            'user_limit' => $data->user_limit
        ]);
        return $newData;
    }

    public function editCoupon($id){
        $coupon = $this->coupon->find($id);
        return $coupon;
    }

    public function updateCoupon($data,$id){
        $update = $this->coupon->find($id);
        $update->code = $data->code;
        $update->description = $data->description;
        $update->coupon_total = $data->coupon_total;
        $update->expired_date = $data->expired_date;
        $update->type = $data->type;
        $update->amount = $data->amount;
        $update->maximum_amount = $data->max_amount;
        if($data->type == 'fixed_total')
            $update->maximum_amount = null;
        $update->minimum_amount = $data->min_amount;
        $update->user_limit = $data->user_limit;
        if($data->limit == '0')
            $update->user_limit = 0;
        $update->save();
        return $update;
    }

    public function deleteCoupon($id){
        $data = $this->coupon->find($id);
        $data->delete();
        if($data)
            return $data;
    }
}