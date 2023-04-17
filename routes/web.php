<?php

use Illuminate\Support\Facades\Route;
use App\Models\Coupon;
use App\Http\Resources\CouponCollection;
use App\Http\Resources\OrderResource;


Route::get('/', function () {
    $coupons = Coupon::with("order")->paginate(10);
    return $coupons;
});
