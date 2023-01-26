<?php

namespace App\Http\Controllers\Admin;

use App\Models\Deposit;
use App\Models\Gateway;
use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    protected $depoRelations = ['gateway'];

    public function pending()
    {
        $pageTitle = 'Pending Payments';
        $emptyMessage = 'No pending payments.';
        $deposits = Deposit::where('method_code', '>=', 1000)->with($this->depoRelations)->where('status', 2)->orderBy('id','desc')->paginate(getPaginate());
        return view('admin.deposit.log', compact('pageTitle', 'emptyMessage', 'deposits'));
    }


    public function approved()
    {
        $pageTitle = 'Approved Payments';
        $emptyMessage = 'No approved payments.';
        $deposits = Deposit::where('method_code','>=',1000)->with($this->depoRelations)->where('status', 1)->orderBy('id','desc')->paginate(getPaginate());
        return view('admin.deposit.log', compact('pageTitle', 'emptyMessage', 'deposits'));
    }

    public function successful()
    {
        $pageTitle = 'Successful Payments';
        $emptyMessage = 'No successful payments.';
        $deposits = Deposit::where('status', 1)->with($this->depoRelations)->orderBy('id','desc')->paginate(getPaginate());
        return view('admin.deposit.log', compact('pageTitle', 'emptyMessage', 'deposits'));
    }

    public function rejected()
    {
        $pageTitle = 'Rejected Payments';
        $emptyMessage = 'No rejected payments.';
        $deposits = Deposit::where('method_code', '>=', 1000)->with($this->depoRelations)->where('status', 3)->orderBy('id','desc')->paginate(getPaginate());
        return view('admin.deposit.log', compact('pageTitle', 'emptyMessage', 'deposits'));
    }

    public function deposit()
    {
        $pageTitle = 'Payments History';
        $emptyMessage = 'No payments history available.';
        $deposits = Deposit::where('status','!=',0)->with($this->depoRelations)->orderBy('id','desc')->paginate(getPaginate());
        $successful = Deposit::where('status',1)->sum('amount');
        $pending = Deposit::where('status',2)->sum('amount');
        $rejected = Deposit::where('status',3)->sum('amount');
        return view('admin.deposit.log', compact('pageTitle', 'emptyMessage', 'deposits','successful','pending','rejected'));
    }

    public function depositViaMethod($method,$type = null){
        $method = Gateway::where('alias',$method)->firstOrFail();
        if ($type == 'approved') {
            $pageTitle = 'Approved Payment Via '.$method->name;
            $deposits = Deposit::where('method_code','>=',1000)->with($this->depoRelations)->where('method_code',$method->code)->where('status', 1)->orderBy('id','desc');
        }elseif($type == 'rejected'){
            $pageTitle = 'Rejected Payment Via '.$method->name;
            $deposits = Deposit::where('method_code','>=',1000)->with($this->depoRelations)->where('method_code',$method->code)->where('status', 3)->orderBy('id','desc');

        }elseif($type == 'successful'){
            $pageTitle = 'Successful Payment Via '.$method->name;
            $deposits = Deposit::where('status', 1)->with($this->depoRelations)->where('method_code',$method->code)->orderBy('id','desc');
        }elseif($type == 'pending'){
            $pageTitle = 'Pending Payment Via '.$method->name;
            $deposits = Deposit::where('method_code','>=',1000)->with($this->depoRelations)->where('method_code',$method->code)->where('status', 2)->orderBy('id','desc');
        }else{
            $pageTitle = 'Payment Via '.$method->name;
            $deposits = Deposit::where('status','!=',0)->with($this->depoRelations)->where('method_code',$method->code)->orderBy('id','desc');
        }
        $deposits = $deposits->paginate(getPaginate());
        $successful = $deposits->where('status',1)->sum('amount');
        $pending = $deposits->where('status',2)->sum('amount');
        $rejected = $deposits->where('status',3)->sum('amount');
        $methodAlias = $method->alias;
        $emptyMessage = 'No Payments Found';
        return view('admin.deposit.log', compact('pageTitle', 'emptyMessage', 'deposits','methodAlias','successful','pending','rejected'));
    }

    public function search(Request $request, $scope)
    {
        $search = $request->search;
        $emptyMessage = 'No search result was found.';
        $deposits = Deposit::where('status','!=',0)->where(function ($q) use ($search) {
            $q->where('trx', 'like', "%$search%");
        })->with($this->depoRelations);
        if ($scope == 'pending') {
            $pageTitle = 'Pending Payments Search';
            $deposits = $deposits->where('method_code', '>=', 1000)->where('status', 2);
        }elseif($scope == 'approved'){
            $pageTitle = 'Approved Payments Search';
            $deposits = $deposits->where('method_code', '>=', 1000)->where('status', 1);
        }elseif($scope == 'rejected'){
            $pageTitle = 'Rejected Payments Search';
            $deposits = $deposits->where('method_code', '>=', 1000)->where('status', 3);
        }else{
            $pageTitle = 'Payments History Search';
        }

        $deposits = $deposits->paginate(getPaginate());
        $pageTitle .= '-' . $search;

        return view('admin.deposit.log', compact('pageTitle', 'search', 'scope', 'emptyMessage', 'deposits'));
    }

    public function dateSearch(Request $request,$scope = null){
        $search = $request->date;
        if (!$search) {
            return back();
        }
        $date = explode('-',$search);
        $start = @$date[0];
        $end = @$date[1];
        // date validation
        $pattern = "/\d{2}\/\d{2}\/\d{4}/";
        if ($start && !preg_match($pattern,$start)) {
            $notify[] = ['error','Invalid date format'];
            return redirect()->route('admin.deposit.list')->withNotify($notify);
        }
        if ($end && !preg_match($pattern,$end)) {
            $notify[] = ['error','Invalid date format'];
            return redirect()->route('admin.deposit.list')->withNotify($notify);
        }


        if ($start) {
            $deposits = Deposit::where('status','!=',0)->whereDate('created_at',Carbon::parse($start));
        }
        if($end){
            $deposits = Deposit::where('status','!=',0)->whereDate('created_at','>=',Carbon::parse($start))->whereDate('created_at','<=',Carbon::parse($end));
        }
        if ($request->method) {
            $method = Gateway::where('alias',$request->method)->firstOrFail();
            $deposits = $deposits->where('method_code',$method->code);
        }
        if ($scope == 'pending') {
            $deposits = $deposits->where('method_code', '>=', 1000)->where('status', 2);
        }elseif($scope == 'approved'){
            $deposits = $deposits->where('method_code', '>=', 1000)->where('status', 1);
        }elseif($scope == 'rejected'){
            $deposits = $deposits->where('method_code', '>=', 1000)->where('status', 3);
        }
        $deposits = $deposits->orderBy('id','desc')->with($this->depoRelations)->paginate(getPaginate());
        $pageTitle = ' Payments Log';
        $emptyMessage = 'No Payments Found';
        $dateSearch = $search;
        return view('admin.deposit.log', compact('pageTitle', 'emptyMessage', 'deposits','dateSearch','scope'));
    }

    public function details($id)
    {
        $general = GeneralSetting::first();
        $deposit = Deposit::where('id', $id)->with($this->depoRelations)->firstOrFail();
        $pageTitle = $deposit->invoice->name.' payment ' . showAmount($deposit->amount) . ' '.$general->cur_text;
        $details = ($deposit->detail != null) ? json_encode($deposit->detail) : null;
        return view('admin.deposit.detail', compact('pageTitle', 'deposit','details'));
    }


    public function approve(Request $request)
    {

        $request->validate(['id' => 'required|integer']);
        $deposit = Deposit::where('id',$request->id)->where('status',2)->firstOrFail();
        $deposit->status = 1;
        $deposit->save();

        $invoice = $deposit->invoice;
        $invoice->status = 1;
        $invoice->save();

        $general = GeneralSetting::first();

        notify($invoice, 'PAYMENT_APPROVE', [
            'method_name' => $deposit->gatewayCurrency()->name,
            'method_currency' => $deposit->method_currency,
            'method_amount' => showAmount($deposit->final_amo),
            'amount' => showAmount($deposit->amount),
            'charge' => showAmount($deposit->charge),
            'currency' => $general->cur_text,
            'rate' => showAmount($deposit->rate),
            'trx' => $deposit->trx,

            'discount'=>showAmount($invoice->discount, 2),
            'status'=>'Pending',
            'name'=>$invoice->name,
            'email'=>$invoice->email,
            'phone'=>$invoice->phone,
            'ordered_at'=>showDateTime($invoice->created_at),
            'track'=>$invoice->track_id,
        ]);

        $notify[] = ['success', 'Payment request has been approved.'];
        return redirect()->route('admin.deposit.pending')->withNotify($notify);
    }

    public function reject(Request $request)
    {

        $request->validate([
            'id' => 'required|integer',
            'message' => 'required|max:250'
        ]);
        $deposit = Deposit::where('id',$request->id)->where('status',2)->firstOrFail();

        $deposit->admin_feedback = $request->message;
        $deposit->status = 3;
        $deposit->save();

        $invoice = $deposit->invoice;
        $invoice->status = 6;
        $invoice->save();

        $general = GeneralSetting::first();
        notify($invoice, 'PAYMENT_REJECT', [
            'method_name' => $deposit->gatewayCurrency()->name,
            'method_currency' => $deposit->method_currency,
            'method_amount' => showAmount($deposit->final_amo),
            'amount' => showAmount($deposit->amount),
            'charge' => showAmount($deposit->charge),
            'currency' => $general->cur_text,
            'rate' => showAmount($deposit->rate),
            'trx' => $deposit->trx,
            'rejection_message' => $request->message,

            'discount'=>showAmount($invoice->discount, 2),
            'status'=>'Pending',
            'name'=>$invoice->name,
            'email'=>$invoice->email,
            'phone'=>$invoice->phone,
            'ordered_at'=>showDateTime($invoice->created_at),
            'track'=>$invoice->track_id,
        ]);

        $notify[] = ['success', 'Payment request has been rejected.'];
        return  redirect()->route('admin.deposit.pending')->withNotify($notify);

    }
}
