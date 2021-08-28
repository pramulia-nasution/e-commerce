<?php

namespace App\Repositories\Coupons;

interface CouponsRepository{
    public function pagingAllCoupons();
    public function insertCoupon($request);
    public function editCoupon($id);
    public function updateCoupon($request,$id);
    public function deleteCoupon($id);

}