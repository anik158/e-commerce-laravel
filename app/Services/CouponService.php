<?php

namespace App\Services;

use App\Models\Admin\Coupon;

class CouponService
{
    public function store($request)
    {
        $data = $request->all();
        return Coupon::create($data);
    }

    public function update($request, $coupon)
    {
        $coupon->update($request->all());
        return $coupon;
    }

    public function destroy($coupon)
    {
        $coupon->delete();
    }
}
