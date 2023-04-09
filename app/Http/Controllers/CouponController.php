<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Resources\CouponCollection;
use App\Http\Requests\CouponRequest;
use App\Http\Resources\CouponResource;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::paginate(10);
        return new CouponCollection($coupons);
    }

    public function store(CouponRequest $request)
    {
        $coupon = Coupon::create($request->all());

        return new CouponResource($coupon);
    }

    public function show(Coupon $coupon)
    {
        return new CouponResource($coupon);
    }

    public function update(CouponRequest $request, Coupon $coupon)
    {
        $coupon->update($request->all());

        return new CouponResource($coupon);
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return response(null, 202);
    }
}
