<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\UserCustomTea;
use App\Models\CustomTea;
use App\Models\CustomTeaOrder;
use App\Models\Order;
use App\Models\Product;
use App\Models\PaymentGateway;
use App\Models\Refund;
use Carbon\Carbon;

class CustomTeaOrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function orders()
    {
        $user = Auth::guard('web')->user();
        $orders = CustomTeaOrder::where('user_id','=',$user->id)->orderBy('id','desc')->get();
        return view('user.customteaorder.index',compact('user','orders'));
    }
    public function review($id)
    {
        $data = CustomTeaOrder::findOrFail($id);
        return view('user.customteaorder.review',compact('data'));
    }
    public function reviewsubmit(Request $request)
        {
            $ck = 0;
            $orders = CustomTeaOrder::where('id','=',$request->order_id)->first();
          
            
                $user = Auth::guard('web')->user();
                if($orders->rating != 0)
                {
                return response()->json(array('errors' => [ 0 => 'You Have Reviewed Already.' ]));
                }
                // $orders->update($data);
                $orders['rating'] = $request->rating;
                $orders['comment'] = $request->comment;
                $orders->save();
                $data[0] = 'Your Rating Submitted Successfully.';
                return response()->json($data);
            
        }

    

    public function orderCancel($order_id)
    {
        $user = Auth::user();
        $order = CustomTeaOrder::where('user_id',$user->id)->where('id',$order_id)->first();
        $order->status = 'declined';
        $order->update();
        $addTotal = $order->pay_amount + $order->wellet_price;
        $user->balance = $user->balance + $addTotal;
        $user->update();
        return redirect(route('user-customtea-orders'))->with('success','Order Cancel Successfully');
        
    }


    public function orderRefund(Request $request)
    {
       
        $data = new Refund();
        $data->user_id = $request->user_id;
        $data->order_number = $request->order_number;
        $data->message = $request->message;
        $data->created_at = Carbon::now();
        $data->save();
        return redirect(route('user-customtea-orders'))->with('success','Order Refund Request Submit Successfully');
    }

    public function cancelRefund($order_number)
    {
        $data = Refund::where('order_number',$order_number)->first();
        if($data){
            $data->delete();
            return redirect(route('user-customtea-orders'))->with('success','Order Refund Request Cancel Successfully'); 
        }else{
            return redirect(route('user-customtea-orders'))->with('success','Somthing is wrong'); 
        }
        
    }


    public function order($id)
    {
        $user = Auth::guard('web')->user();
        $order = CustomTeaOrder::findOrfail($id);
        return view('user.customteaorder.details',compact('user','order'));
    }

    public function orderdownload($slug,$id)
    {
        $user = Auth::guard('web')->user();
        $order = CustomTeaOrder::where('order_number','=',$slug)->first();
        $prod = Product::findOrFail($id);
        if(!isset($order) || $prod->type == 'Physical' || $order->user_id != $user->id)
        {
            return redirect()->back();
        }
        return response()->download(public_path('assets/files/'.$prod->file));
    }

    public function orderprint($id)
    {
        $user = Auth::guard('web')->user();
        $order = CustomTeaOrder::findOrfail($id);
        return view('user.customteaorder.print',compact('user','order'));
    }

    public function trans()
    {
        $id = $_GET['id'];
        $trans = $_GET['tin'];
        $order = CustomTeaOrder::findOrFail($id);
        $order->txnid = $trans;
        $order->update();
        $data = $order->txnid;
        return response()->json($data);            
    }  

}
