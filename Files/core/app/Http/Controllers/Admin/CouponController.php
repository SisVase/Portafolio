<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Product;

class CouponController extends Controller
{

    public function index(){
        $pageTitle = 'Manage Coupon';
        $coupons = Coupon::latest()->paginate(getPaginate());
        $products = Product::latest()->get();
        $emptyMessage = 'Data Not Found';
        return view('admin.coupon.index', compact('pageTitle', 'coupons', 'emptyMessage', 'products'));
    }

    public function add(Request $request){

        $request->validate([
            'name'=> 'required|max:255',
            'code'=> 'required|max:255|unique:coupons,code',
            'type'=> 'required|in:0,1', // 0=> Percent, 1=>Fixed
            'discount'=> 'required|numeric|gte:0',
            'min_order_amount'=> 'required|numeric|gte:0',
            'status' => 'sometimes|in:on'
        ]);

        $new = new Coupon();
        $new->name = $request->name;
        $new->code = $request->code;
        $new->type = $request->type;
        $new->discount = $request->discount;
        $new->min_order_amount = $request->min_order_amount;
        $new->status = isset($request->status) ? 1 : 0;
        $new->save();

        $notify[] = ['success', 'New coupon added successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request){

        $request->validate([
            'id'=> 'required|exists:coupons,id',
            'name'=> 'required|max:255',
            'code'=> 'required|max:255|unique:coupons,code,'.$request->id,
            'type'=> 'required|in:0,1', // 0=> Percent, 1=>Fixed
            'discount'=> 'required|numeric|gte:0',
            'min_order_amount'=> 'required|numeric|gte:0',
            'status' => 'sometimes|in:on'
        ]);

        $find = Coupon::find($request->id);
        $find->name = $request->name;
        $find->code = $request->code;
        $find->type = $request->type;
        $find->discount = $request->discount;
        $find->min_order_amount = $request->min_order_amount;
        $find->status = isset($request->status) ? 1 : 0;
        $find->save();

        $notify[] = ['success', 'Coupon updated successfully'];
        return back()->withNotify($notify);
    }

    public function delete(Request $request){

        $request->validate([
            'id'=> 'required|exists:coupons,id',
        ]);

        $find = Coupon::find($request->id);
        $find->delete();

        $notify[] = ['success', 'Coupon deleted successfully'];
        return back()->withNotify($notify);
    }

}
