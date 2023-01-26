<?php

namespace App\Http\Controllers;
use App\Models\AdminNotification;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Page;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Review;
use App\Models\SupportAttachment;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use App\Models\Invoice;
use App\Models\Deposit;
use App\Models\Order;
use App\Models\ProductImage;
use App\Models\GatewayCurrency;
use App\Models\Coupon;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;


class SiteController extends Controller
{
    public function __construct(){
        $this->activeTemplate = activeTemplate();
    }

    public function index(){  
        $count = Page::where('tempname',$this->activeTemplate)->where('slug','home')->count();
        if($count == 0){
            $page = new Page();
            $page->tempname = $this->activeTemplate;
            $page->name = 'HOME';
            $page->slug = 'home';
            $page->save();
        }

        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }

        $pageTitle = 'Home';
        $sections = Page::where('tempname',$this->activeTemplate)->where('slug','home')->first();
        return view($this->activeTemplate . 'home', compact('pageTitle','sections'));
    }

    public function pages($slug)
    {
        $page = Page::where('tempname',$this->activeTemplate)->where('slug',$slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle','sections'));
    }


    public function contact()
    {
        $pageTitle = "Contact Us";
        return view($this->activeTemplate . 'contact',compact('pageTitle'));
    }


    public function contactSubmit(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|max:40',
            'subject' => 'required|max:100',
            'message' => 'required',
        ]);

        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->phone = $request->phone;
        $ticket->priority = 2;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->title = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view',$ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->supportticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'ticket created successfully!'];

        return redirect()->route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return redirect()->back();
    }

    public function blogDetails($slug, $id){
        $blog = Frontend::where('id',$id)->where('data_keys','blog.element')->firstOrFail();
        $latestBlogs = Frontend::where('data_keys','blog.element')->latest()->take(10)->get();
        $pageTitle = 'Blog Details';
        return view($this->activeTemplate.'blog_details',compact('blog','pageTitle', 'latestBlogs'));
    }


    public function cookieAccept(){
        session()->put('cookie_accepted',true);
        return ['success'=>true, 'message'=>'Cookie accepted successfully'];
    }

    public function placeholderImage($size = null){
        $imgWidth = explode('x',$size)[0];
        $imgHeight = explode('x',$size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if($imgHeight < 100 && $fontSize > 30){
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    public function blogs(){
        $pageTitle = 'Blogs';
        $sections = Page::where('tempname',$this->activeTemplate)->where('slug','blogs')->first();
        return view($this->activeTemplate.'blogs',compact('pageTitle', 'sections'));
    }

    public function tracking(Request $request){
        $pageTitle = 'Order Tracking';
        $order = Invoice::where('track_id', $request->search)->where('status', '!=', 0)->first();
        return view($this->activeTemplate.'tracking',compact('pageTitle', 'order'));
    }

    public function policyDetails($policy, $id){
        $content = Frontend::where('data_keys','policy_pages.element')->where('id', $id)->firstOrFail();
        $pageTitle = ucfirst($policy);
        return view($this->activeTemplate.'policy_page',compact('pageTitle', 'content'));
    }

    public function about(){
        $pageTitle = 'About';
        $sections = Page::where('tempname',$this->activeTemplate)->where('slug','about')->first();
        return view($this->activeTemplate.'about',compact('pageTitle', 'sections'));
    }

    public function updateCart(Request $request){

        $product = Product::where('status', 1)->firstOrFail();

        $request->validate([
            'qty'=> 'required|integer|gt:0',
            'size'=> 'nullable|in:'.implode(',', $product->size ?? []),
            'color'=> 'nullable|in:'.implode(',', $product->color ? array_column($product->color, 'code') : null ?? []),
        ]);

        if(session()->has('cart')){

            $cart = Cart::where('unique_id', session()->get('cart'))
                        ->where('color', $request->color)
                        ->where('size', $request->size)
                        ->first();

            if($cart){
                $cart->qty += $request->qty;
                $cart->save();
            }else{
                $new = new Cart();
                $new->unique_id = session()->get('cart');
                $new->color = $request->color;
                $new->size = $request->size;
                $new->qty = $request->qty;
                $new->save();
            }

        }else{
            $uniqueId = time();

            $new = new Cart();
            $new->unique_id = $uniqueId;
            $new->color = $request->color;
            $new->size = $request->size;
            $new->qty = $request->qty;
            $new->save();

            session()->put('cart', $uniqueId);
        }

        return redirect()->route('checkout');

    }

    public function checkout(){

        $product = Product::where('status', 1)->first();

        if(!$product){
            $notify[] = ['error', 'Sorry, Unavailable product'];
            return redirect()->route('home')->withNotify($notify);
        }

        $pageTitle = 'Checkout';
        $carts = Cart::where('unique_id', session()->get('cart'))->latest()->get();

        if($carts->count() == 0){
            $notify[] = ['error', 'Sorry, Empty Cart'];
            return redirect()->route('home')->withNotify($notify);
        }

        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->orderby('method_code')->get();

        $paymentText = Frontend::where('data_keys', 'payment.content')->first();
        session()->forget('coupon');

        return view($this->activeTemplate.'checkout',compact('pageTitle', 'carts', 'gatewayCurrency', 'paymentText'));
    }

    public function deleteCart(Request $request){

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:carts,id'
        ]);

        if(!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }

        $find = Cart::where('id', $request->id)->where('unique_id', session()->get('cart'))->first();

        if(!$find){
            return response()->json(['success'=> false, 'message'=> 'Invalid Request']);
        }

        $find->delete();
        $product = Product::first();

        return ['success'=> true, 'message'=>'Delete item successfully', 'totalAmount'=> afterDiscount($product->price, $product->discount) * $find->qty];
    }

    public function updateQty(Request $request){

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:carts,id',
            'input' => 'required|integer|gt:0',
        ]);

        if($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }

        $find = Cart::where('id', $request->id)->where('unique_id', session()->get('cart'))->first();

        if(!$find){
            return response()->json(['success'=>false, 'message'=>'Invalid Request']);
        }

        $product = Product::first();

        $afterChange = 0;
        $type = null;
        $afterDiscountPrice = afterDiscount($product->price, $product->discount);

        if($request->input > $find->qty){
            $qty = $request->input - $find->qty;
            $find->qty += $qty;

            $type = '+';
            $afterChange = $qty * $afterDiscountPrice;
        }else{
            $qty = $find->qty - $request->input;
            $find->qty -= $qty;

            $type = '-';
            $afterChange = $qty * $afterDiscountPrice;
        }

        $find->save();

        return response()->json(['success'=>true, 'totalPrice'=>$find->qty * $afterDiscountPrice , 'afterChange'=>$afterChange, 'type'=>$type]);
    }

    public function coupon(Request $request){

        $validator = Validator::make($request->all(), [
            'input' => 'required|exists:coupons,code'
        ]);

        if(!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }

        $find = Coupon::where('code', $request->input)->where('status', 1)->first();

        if(!$find){
            return response()->json(['success'=>false, 'message'=>'Invalid Request']);
        }

        $general = GeneralSetting::first();
        $discount = 0;

        if($find->type == 0){
            $discount = getAmount($find->discount, 2).'%';
        }else{
            $discount = $general->cur_sym.getAmount($find->discount, 2);
        }

        session()->put('coupon', $find->id);
        return response()->json(['success'=> true, 'message'=> 'Coupon applied successfully', 'row'=>$find, 'discount'=>$discount]);
    }

    public function currencyInfo(Request $request){

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:gateway_currencies,id'
        ]);

        if(!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }

        $method = GatewayCurrency::where('id', $request->id)->whereHas('method', function ($gate){
                    $gate->where('status', 1);
                })->with('method')->orderby('method_code')->first();


        if(!$method){
            return response()->json(['success'=>false, 'message'=>'Invalid Request']);
        }

        return response()->json(['success'=> true, 'message'=> null, 'row'=>$method]);
    }

    public function proceedCheckout(Request $request){

        $product = Product::where('status', 1)->firstOrFail();

        $carts = Cart::where('unique_id', session()->get('cart'))->latest()->get();

        if($carts->count() == 0){
            $notify[] = ['error', 'Sorry, Empty Cart'];
            return redirect()->route('home')->withNotify($notify);
        }

        $customValidation = [];
        $customValidation['gatewayId'] = 'required|exists:gateway_currencies,id';
        $customValidation['name'] = 'required|max:255';
        $customValidation['email'] = 'required|max:250|email';
        $customValidation['phone'] = 'required|max:30';

        $general = GeneralSetting::first();

        if($general->shipping != null && gettype($general->shipping) == 'object'){
            foreach($general->shipping as $key => $value){
                $rule = $value->type == 'text' ? $rule = '|string' : null;
                $customValidation[$key] = $value->validation.$rule;
            }
        }

        $request->validate($customValidation);

        $collection = collect($request);
        $reqField = [];

        if($general->shipping != null && gettype($general->shipping) == 'object'){
            foreach($collection as $k => $v) {
                foreach ($general->shipping as $inKey => $inVal){
                    if($k != $inKey){
                        continue;
                    }else{
                        $reqField[$inKey] = $v;
                            $reqField[$inKey] = [
                                'field_name' => $inKey,
                                'field_value' => $v,
                                'type' => $inVal->type,
                            ];
                    }
                }
            }
        }

        $gate = GatewayCurrency::where('id', $request->gatewayId)->whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->first(['method_code', 'currency', 'rate', 'percent_charge', 'fixed_charge']);

        $price = $carts->sum('qty') * afterDiscount($product->price, $product->discount);
        $coupon = Coupon::find(session()->get('coupon'));
        $dicsount = 0;

        if($coupon && $price >= $coupon->min_order_amount){
            if($coupon->type == 0){
                $dicsount = ($price * $coupon->discount) / 100;
            }
            else{
                $dicsount = $price - $coupon->discount;
            }

            $coupon->used += 1;
            $coupon->save();
        }

        $finalPrice = $price - $dicsount;

        $charge = $gate->fixed_charge + ($price * $gate->percent_charge / 100);
        $finalPrice = $finalPrice += $charge;
        $final_amo = $finalPrice * $gate->rate;

        $trackId = getTrx(8).date('dMyis');

        $invoice = new Invoice();
        $invoice->track_id = $trackId;
        $invoice->price = $price;
        $invoice->discount = $dicsount;
        $invoice->charge = $charge;
        $invoice->final_price = $finalPrice;

        $invoice->status =  0;

        $invoice->name = $request->name;
        $invoice->email = $request->email;
        $invoice->phone = $request->phone;

        $invoice->shipping_address = $reqField;
        $invoice->save();

        foreach($carts as $cart){
            $order = new Order();
            $order->invoice_id = $invoice->id;
            $order->qty = $cart->qty;
            $order->size = $cart->size;
            $order->color = $cart->color;
            $order->save();
        }

        $data = new Deposit();
        $data->invoice_id = $invoice->id;
        $data->method_code = $gate->method_code;
        $data->method_currency = strtoupper($gate->currency);
        $data->amount = $price;
        $data->charge = $charge;
        $data->rate = $gate->rate;
        $data->final_amo = $final_amo;
        $data->btc_amo = 0;
        $data->btc_wallet = "";
        $data->trx = getTrx();
        $data->try = 0;
        $data->status = 0;
        $data->save();

        session()->put('Track', $data->trx);
        return redirect()->route('deposit.preview');

    }

    public function productDetails(){

        $product = Product::where('status', 1)->first();

        if(!$product){
            $notify[] = ['error', 'Sorry, Unavailable product'];
            return redirect()->route('home')->withNotify($notify);
        }

        $pageTitle = 'Product Details';
        $reviews = Review::where('status', 1)->latest()->paginate(getPaginate());
        $reviewCount = Review::where('status', 1)->count();
        $images = ProductImage::latest()->get();

        return view($this->activeTemplate.'product_details',compact('pageTitle', 'reviews', 'images', 'reviewCount'));
    }

    public function addReview(Request $request){

        $product = Product::where('status', 1)->first();

        if(!$product){
            $notify[] = ['error', 'Sorry, Unavailable product'];
            return redirect()->route('home')->withNotify($notify);
        }

        $request->validate([
            'rating'=> 'required|between:1,5',
            'name'=> 'nullable|max:250',
            'remark'=> 'nullable|max:60000',
        ]);

        $new = new Review();
        $new->rating = $request->rating;
        $new->name = $request->name;
        $new->remark = $request->remark;
        $new->status = 0;
        $new->save();

        $notify[] = ['success', 'Review created successfully'];
        return back()->withNotify($notify);
    }


}
