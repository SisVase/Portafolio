<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Track;
use App\Models\GeneralSetting;
use Carbon\Carbon;

class OrderController extends Controller
{

    public function pending(Request $request){
        $pageTitle = 'Pending Order';
        $invoices = Invoice::when($request->search, function($query) use ($request){
                        $query->where('track_id', $request->search);
                    })->where('status', 1)->latest()->with('deposit')->paginate(getPaginate());
        $emptyMessage = 'Data Not Found';
        return view('admin.order.index', compact('pageTitle', 'invoices', 'emptyMessage'));
    }

    public function processing(Request $request){
        $pageTitle = 'Processing Order';
        $invoices = Invoice::when($request->search, function($query) use ($request){
                        $query->where('track_id', $request->search);
                    })->where('status', 2)->latest()->with('deposit')->paginate(getPaginate());
        $emptyMessage = 'Data Not Found';
        return view('admin.order.index', compact('pageTitle', 'invoices', 'emptyMessage'));
    }

    public function shipping(Request $request){
        $pageTitle = 'Shipping Order';
        $invoices = Invoice::when($request->search, function($query) use ($request){
                        $query->where('track_id', $request->search);
                    })->where('status', 3)->latest()->with('deposit')->paginate(getPaginate());
        $emptyMessage = 'Data Not Found';
        return view('admin.order.index', compact('pageTitle', 'invoices', 'emptyMessage'));
    }

    public function delivered(Request $request){
        $pageTitle = 'Delivered Order';
        $invoices = Invoice::when($request->search, function($query) use ($request){
                        $query->where('track_id', $request->search);
                    })->where('status', 4)->latest()->with('deposit')->paginate(getPaginate());
        $emptyMessage = 'Data Not Found';
        return view('admin.order.index', compact('pageTitle', 'invoices', 'emptyMessage'));
    }

    public function all(Request $request){
        $pageTitle = 'All Order';
        $invoices = Invoice::when($request->search, function($query) use ($request){
                        $query->where('track_id', $request->search);
                    })->where('status', '!=', 0)->latest()->with('deposit')->paginate(getPaginate());
        $emptyMessage = 'Data Not Found';
        return view('admin.order.index', compact('pageTitle', 'invoices', 'emptyMessage'));
    }

    public function details($id){
        $invoice = Invoice::findOrFail($id);
        $tracks = Track::where('invoice_id', $id)->paginate(getPaginate(15));
        $pageTitle = 'Order Details';
        $emptyMessage = 'Data Not Found';
        return view('admin.order.details', compact('pageTitle', 'invoice', 'emptyMessage', 'tracks'));
    }

    public function updateStatus(Request $request){

        $request->validate([
            'id' => 'required|exists:invoices,id',
            'status' => 'required|in:1,2,3,4',
        ]);

        $find = Invoice::where('id', $request->id)->whereIn('status', [1, 2, 3, 5])->firstOrFail();
        $find->status = $request->status;
        $find->save();

        if($find->status == 4){

            $general = GeneralSetting::first();

            notify($find, 'ORDER_DELIVERED', [
                'discount'=>showAmount($find->discount, 2),
                'amount'=>showAmount($find->final_price, 2),
                'charge'=>showAmount($find->charge, 2),
                'status'=>'Delivered',
                'name'=>$find->name,
                'email'=>$find->email,
                'phone'=>$find->phone,
                'ordered_at'=>showDateTime($find->created_at),
                'track'=>$find->track_id,
                'currency' => $general->cur_text,
            ]);
        }

        $notify[] = ['success', 'Order status updated successfully'];
        return back()->withNotify($notify);
    }

    public function addTrack(Request $request){

        $request->validate([
            'info'=>'required|max:255',
            'id' => 'required|exists:invoices,id',
            'date'=> 'required|string'
        ]);

        $new = new Track();
        $new->invoice_id = $request->id;
        $new->info = $request->info;
        $new->date = Carbon::parse($request->date)->toDateTimeString();
        $new->save();

        $notify[] = ['success', 'Order tracking info created successfully'];
        return back()->withNotify($notify);
    }

    public function deleteTrack(Request $request){

        $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'id' => 'required|exists:tracks,id',
        ]);

        $find = Track::where('id', $request->id)->where('invoice_id', $request->invoice_id)->firstOrFail();
        $find->delete();

        $notify[] = ['success', 'Order tracking info deleted successfully'];
        return back()->withNotify($notify);
    }

    public function updateTrack(Request $request){

        $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'id' => 'required|exists:tracks,id',
            'info'=>'required|max:255',
        ]);

        $find = Track::where('id', $request->id)->where('invoice_id', $request->invoice_id)->firstOrFail();
        $find->info = $request->info;
        $find->save();

        $notify[] = ['success', 'Order tracking info updated successfully'];
        return back()->withNotify($notify);
    }



}
