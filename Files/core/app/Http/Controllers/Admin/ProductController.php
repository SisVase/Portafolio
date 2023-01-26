<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\GeneralSetting;

class ProductController extends Controller
{

    public function index(){
        $product = Product::first();
        $pageTitle = 'Manage Product';
        $discount = 0;
        $afterDiscount = 0;
        if ($product) {
            $discount = ($product->discount/100) * $product->price;
            $afterDiscount = $product->price - $discount;
        }

        $images = ProductImage::get();
        return view('admin.product.index', compact('pageTitle', 'product', 'afterDiscount', 'images'));
    }

    public function update(Request $request){

        $find = Product::first();

        if (!$find) {
            $find = new Product();
        }

        $request->validate([

            'size'=> 'array|max:255',
            'color'=> 'array|max:255',

            'name'=> 'required|max:255',
            'price'=> 'required|numeric|gt:0',
            'discount'=> 'nullable|numeric|gt:0',
            'short_description'=> 'required',
            'description'=> 'required',
            'image' => 'nullable|array',
            'image.*' => 'nullable|image|mimes:jpg,jpeg,png',
            'status' => 'sometimes|in:on',
        ]);

        $requestColors = $request->color ?? [];
        $colors = [];

        foreach($find->color as $data){
            if( in_array($data->code, $requestColors) ){
                $colors[] = $data;
            }
        }

        $find->name = $request->name;

        $find->size = $request->size ?? [];
        $find->color = $colors;

        $find->short_description = $request->short_description;
        $find->description = $request->description;
        $find->discount = $request->discount ?? 0;
        $find->price = $request->price;
        $find->status = $request->status ? 1 : 0;

        if($request->hasFile('image')){
            foreach($request->image as $data){
                $new = new ProductImage();
                $new->image = uploadImage($data, imagePath()['product']['path'], imagePath()['product']['size']);
                $new->save();
            }
        }

        $find->save();

        $notify[] = ['success', 'Product info updated successfully'];
        return back()->withNotify($notify);
    }

    public function shippingForm(){
        $pageTitle = 'Shipping Form';
        return view('admin.shipping_form', compact('pageTitle'));
    }

    public function shipping(Request $request){

        $request->validate([
            'field_name.*'=> 'required',
            'type.*'=> 'required|in:text,textarea',
            'validation.*'=> 'required|in:required,nullable',
        ],[
            'field_name.*.required'=>'All field is required'
        ]);

        $user_data = [];

        if($request->field_name){
            for($a = 0; $a < count($request->field_name); $a++) {
                $arr = array();
                $arr['field_name'] = strtolower(str_replace(' ', '_', $request->field_name[$a]));
                $arr['field_level'] = $request->field_name[$a];
                $arr['type'] = $request->type[$a];
                $arr['validation'] = $request->validation[$a];
                $user_data[$arr['field_name']] = $arr;
            }
        }

        $general = GeneralSetting::first();

        $general->shipping = $user_data;
        $general->save();

        $notify[] = ['success', 'Shipping form updated successfully'];
        return back()->withNotify($notify);
    }

    public function deleteImage(Request $request){

        $request->validate([
            'id'=> 'required|exists:product_images,id',
        ]);

        $find = ProductImage::where('id', $request->id)->first();
        removeFile(imagePath()['product']['path'].'/'.$find->image);
        $find->delete();

        $notify[] = ['success', 'Product Image Deleted successfully'];
        return back()->withNotify($notify);
    }

    public function addColor(Request $request){

        $request->validate([
            'name' => 'required|max:50',
            'code' => 'required', 'regex:/^[a-f0-9]{6}$/i',
        ]);

        $product = Product::first();
        $newColor = ['color'=>$request->name, 'code'=>$request->code];
        $colors = [];

        foreach($product->color as $index => $data){

            $colors[$index]['color'] = $data->color;
            $colors[$index]['code'] = $data->code;

            if( count($product->color) == $index += 1 ){
                $colors[$index]['color'] = $newColor['color'];
                $colors[$index]['code'] = $newColor['code'];
            }
        }

        $product->color = $colors ? $colors : [$newColor];

        $product->save();

        $notify[] = ['success', 'New Color Added Successfully'];
        return back()->withNotify($notify);
    }



}
