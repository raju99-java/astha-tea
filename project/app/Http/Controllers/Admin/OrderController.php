<?php

namespace App\Http\Controllers\Admin;
use Carbon\Carbon;
use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\Generalsetting;
use App\Models\Order;
use App\Models\OrderTrack;
use App\Models\User;
use App\Models\VendorOrder;
use App\Models\Product;
use App\Models\Refund;
use App\Models\Pickup;
use App\Models\DeliveryBoy;
use App\Models\SalesPerson;
use Datatables;
use Validator;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //*** JSON Request
    public function datatables(Request $request,$status)
    {
        if($status == 'pending'){
            $datas = Order::where('status','=','pending')->select('id','order_type','pay_amount','order_number','currency_sign','currency_value','customer_email','totalQty','created_at');
        }
        elseif($status == 'processing') {
            $datas = Order::where('status','=','processing')->select('id','order_type','pay_amount','order_number','currency_sign','currency_value','customer_email','totalQty','created_at');
        }
        elseif($status == 'delivered') {
            $datas = Order::where('status','=','delivered')->select('id','order_type','pay_amount','order_number','currency_sign','currency_value','customer_email','totalQty','created_at');
        }
        elseif($status == 'completed') {
            $datas = Order::where('status','=','completed')->select('id','order_type','pay_amount','order_number','currency_sign','currency_value','customer_email','totalQty','created_at');
        }
        elseif($status == 'declined') {
            $datas = Order::where('status','=','declined')->select('id','order_type','pay_amount','order_number','currency_sign','currency_value','customer_email','totalQty','created_at');
        }
        else{
          $datas = Order::orderBy('id','desc')->select('id','order_type','pay_amount','order_number','currency_sign','currency_value','customer_email','totalQty','created_at');  
        }
         
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('created_at', function(Order $data) {
                                return date('d-M-Y H:i:s a',strtotime($data->created_at));
                            })
                            ->editColumn('order_number', function(Order $data) {
                                $id = '<a href="'.route('admin-order-invoice',$data->id).'">'.$data->order_number.'</a>';
                                return $id;
                            })
                            ->editColumn('pay_amount', function (Order $data) {
                                return $data->currency_sign . round(($data->pay_amount + $data->wallet_price) * $data->currency_value, 2);
                            })
                            ->addColumn('action', function(Order $data) {
                                $orders = '<a href="javascript:;" data-href="'. route('admin-order-edit',$data->id) .'" class="delivery" data-toggle="modal" data-target="#modal1"><i class="fas fa-dollar-sign"></i> Delivery Status</a>';
                                return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button><div class="action-list"><a href="' . route('admin-order-show',$data->id) . '" > <i class="fas fa-eye"></i> Details</a><a href="javascript:;" class="send" data-email="'. $data->customer_email .'" data-toggle="modal" data-target="#vendorform"><i class="fas fa-envelope"></i> Send</a><a href="javascript:;" data-href="'. route('admin-order-track',$data->id) .'" class="track" data-toggle="modal" data-target="#modal1"><i class="fas fa-truck"></i> Track Order</a>'.$orders.'<a class="send" target="_blank" href="'. route('admin-order-thermal-print',$data->id) .'" ><i class="fas fa-print"></i> Thermal Print</a></div></div>';
                            }) 
                            ->filter(function ($instance) use ($request) {
                                if ($request->get('from_date') != '' && $request->get('to_date') != '') {
                                    $from_date = Carbon::parse($request->get('from_date'))->format('Y-m-d');
                                    $to_date = Carbon::parse($request->get('to_date'))->format('Y-m-d');

                                    $instance->where('created_at', '>=', $from_date)->where('created_at', '<=', $to_date);
                                }
                                if (!empty($request->get('search'))) {
                                    $instance->where(function($w) use($request) {
                                        $search = $request->get('search');
                                        $w->orWhere('customer_email', 'LIKE', "%$search%")
                                        ->orWhere('order_number', 'LIKE', "%$search%")
                                        ->orWhere('totalQty', 'LIKE', "%$search%")
                                        ->orWhere('pay_amount', 'LIKE', "%$search%");
                                    });
                                }
                            })
                            ->rawColumns(['id','action','order_number'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }
    public function index()
    {
        return view('admin.order.index');
    }
    public function local_order_datatables($status)
    {
        $pincodes=Pickup::select('location')->get();
        if(!empty($pincodes)){
            foreach ($pincodes as $key => $value) {    
                      
              $f[] = $value->location;     
            }           
        }
        
          $datas = Order::orderBy('id','desc')->select('id','pay_amount','order_number','currency_sign','currency_value','customer_email','totalQty')->whereIn('customer_zip', $f);
        
         
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('order_number', function(Order $data) {
                                $id = '<a href="'.route('admin-order-invoice',$data->id).'">'.$data->order_number.'</a>';
                                return $id;
                            })
                            ->editColumn('pay_amount', function (Order $data) {
                                return $data->currency_sign . round(($data->pay_amount + $data->wallet_price) * $data->currency_value, 2);
                            })
                            ->addColumn('action', function(Order $data) {
                                $orders = '<a href="javascript:;" data-href="'. route('admin-order-edit',$data->id) .'" class="delivery" data-toggle="modal" data-target="#modal1"><i class="fas fa-dollar-sign"></i> Delivery Status</a>';
                                return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button><div class="action-list"><a href="' . route('admin-order-show',$data->id) . '" > <i class="fas fa-eye"></i> Details</a><a href="javascript:;" class="send" data-email="'. $data->customer_email .'" data-toggle="modal" data-target="#vendorform"><i class="fas fa-envelope"></i> Send</a><a href="javascript:;" data-href="'. route('admin-order-track',$data->id) .'" class="track" data-toggle="modal" data-target="#modal1"><i class="fas fa-truck"></i> Track Order</a>'.$orders.'<a class="send" target="_blank" href="'. route('admin-order-thermal-print',$data->id) .'" ><i class="fas fa-print"></i> Thermal Print</a></div></div>';
                            }) 
                            ->rawColumns(['id','action','order_number'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }
    public function local_order()
    {
        return view('admin.order.local_order');
    }

    public function total_sold_order()
    {
        $data = [];
        return view('admin.order.total_sold_order',compact('data'));
    }
    public function total_sold_order_count(Request $request)
    {
        //--- Validation Section
        $rules = [
            'from_date'      => 'required|date',
            'to_date'       => 'required|date|after_or_equal:from_date',
            
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        $input = $request->all();
        $data=[];
        $data['total_sales'] = Order::where('created_at', '>=', $input['from_date'])->where('created_at', '<=', $input['to_date'])->sum('pay_amount', '+', 'wallet_price');
        $data['total_sold'] = Order::where('created_at', '>=', $input['from_date'])->where('created_at', '<=', $input['to_date'])->count();
         //--- Redirect Section          
         $data['msg'] = 'Please Check The Result.';
         return response()->json($data);
    }

    public function edit($id)
    {
        $data = Order::find($id);
        $delivery=DeliveryBoy::where('status','1')->where('ban','0')->get();
        return view('admin.order.delivery',compact('data','delivery'));
    }


    //*** POST Request
    public function update(Request $request, $id)
    {
        //--- Validation Section
        $rules = [
            'deliver_by'      => 'required',
            
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Logic Section
        $data = Order::findOrFail($id);

        $input = $request->all();
        if ($data->status == "completed"){

        // Then Save Without Changing it.
            $input['status'] = "completed";
            $data->update($input);
            //--- Logic Section Ends
    

        //--- Redirect Section          
        $msg = 'Status Updated Successfully.';
        return response()->json($msg);    
        //--- Redirect Section Ends     

    
            }else{
                if ($input['status'] == "processing"){
    
                 
                    if ($data->status == "processing"){

                    }else{
                        if($data->payment_status=='Pending'){
                            $delivery=DeliveryBoy::where('id',$input['deliver_by'])->where('status','1')->where('ban','0')->first();
                            
                            if(!empty($delivery)){
                                $delivery->collection_amount=$delivery->collection_amount+ ($data->pay_amount+$data->wallet_price+$data->shipping_cost);
                                $delivery->save();
                            }
                        }
                    
                    $gs = Generalsetting::findOrFail(1);
                    if(isset($data->customer_email)){
                    if($gs->is_smtp == 1)
                    {
                        $maildata = [
                            'to' => $data->customer_email,
                            'subject' => 'Your order '.$data->order_number.' is Processing!',
                            'body' => "Hello ".$data->customer_name.","."\n Your order is processing by one of our courier partner.",
                        ];
        
                        $mailer = new GeniusMailer();
                        $mailer->sendCustomMail($maildata);                
                    }
                    else
                    {
                        $to = $data->customer_email;
                        $subject = 'Your order '.$data->order_number.' is Processing!';
                        $msg = "Hello ".$data->customer_name.","."\n Your order is processing by one of our courier partner.";
                        $headers = "MIME-Version: 1.0" . "\r\n";
                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                        $headers .= "From: ".$gs->from_name."<".$gs->from_email.">";
                        mail($to,$subject,$msg,$headers);                
                    }
                }
                }
                }
            if ($input['status'] == "completed"){
    
                foreach($data->vendororders as $vorder)
                {
                    $uprice = User::findOrFail($vorder->user_id);
                    $uprice->current_balance = $uprice->current_balance + $vorder->price;
                    $uprice->update();
                }
    
                $gs = Generalsetting::findOrFail(1);
                $delivery=DeliveryBoy::where('id',$input['deliver_by'])->where('status','1')->where('ban','0')->first();
                
                if(!empty($delivery)){
                    if($data->payment_status=='Pending'){
                    $delivery->collection_amount=$delivery->collection_amount- ($data->pay_amount+$data->wallet_price+$data->shipping_cost);
                    }
                    $delivery->commission=$delivery->commission+(($data->pay_amount+$data->wallet_price+$data->shipping_cost)*($gs->delivery_boy_commission/100));
                    $delivery->save();
                }
                $user = User::find($data->user_id);
                if( $user ){
                    $user->balance = $user->balance + (($data->pay_amount+$data->wallet_price+$data->shipping_cost)*($gs->customer_cashback/100));
                    $user->save();
                }
                // if(!empty($data->salesman_id)){
                //     $salesman=SalesPerson::where('id',$input['salesman_id'])->where('status','1')->where('ban','0')->first();
                //     if( $salesman ){
                //         $salesman->commission = $salesman->commission + (($data->pay_amount+$data->wallet_price+$data->shipping_cost)*($gs->sales_person_commission/100));
                //         $user->save();
                //     }
                // }
                if(isset($data->customer_email)){
                if($gs->is_smtp == 1)
                {
                    $maildata = [
                        'to' => $data->customer_email,
                        'subject' => 'Your order '.$data->order_number.' is Confirmed!',
                        'body' => "Hello ".$data->customer_name.","."\n Thank you for shopping with us. We are looking forward to your next visit.",
                    ];
    
                    $mailer = new GeniusMailer();
                    $mailer->sendCustomMail($maildata);                
                }
                else
                {
                   $to = $data->customer_email;
                   $subject = 'Your order '.$data->order_number.' is Confirmed!';
                   $msg = "Hello ".$data->customer_name.","."\n Thank you for shopping with us. We are looking forward to your next visit.";
                   $headers = "MIME-Version: 1.0" . "\r\n";
                   $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                   $headers .= "From: ".$gs->from_name."<".$gs->from_email.">";
                   mail($to,$subject,$msg,$headers);                
                }
            }
            }
            if ($input['status'] == "declined"){
                $delivery=DeliveryBoy::where('id',$input['deliver_by'])->where('status','1')->where('ban','0')->first();
                
                if(!empty($delivery)){
                    $delivery->collection_amount=$delivery->collection_amount- ($data->pay_amount+$data->wallet_price+$data->shipping_cost);
                    $delivery->commission=$delivery->commission+(($data->pay_amount+$data->wallet_price+$data->shipping_cost)*($gs->delivery_boy_commission/100));
                    $delivery->save();
                }
                // Refund User Wallet If Any
                if($data->user_id != 0){
                    if($data->wallet_price != 0){
                        $user = User::find($data->user_id);
                        if( $user ){
                            $user->balance = $user->balance + $data->wallet_price;
                            $user->save();
                        }
                    }
                }

                $cart = json_decode($data->cart,true);
              
                // Restore Product Stock If Any
                foreach($cart['items'] as $prod)
                {
                    $x = (string)$prod['stock'];
                    if($x != null)
                    {
        
                        $product = Product::findOrFail($prod['item']['id']);
                        $product->stock = $product->stock + $prod['qty'];
                        $product->update();               
                    }
                }

                // Restore Product Size Qty If Any
                foreach($cart['items'] as $prod)
                {
                    $x = (string)$prod['size_qty'];
                    if(!empty($x))
                    {
                        $product = Product::findOrFail($prod['item']['id']);
                        $x = (int)$x;
                        $temp = $product->size_qty;
                        $temp[$prod['size_key']] = $x;
                        $temp1 = implode(',', $temp);
                        $product->size_qty =  $temp1;
                        $product->update();               
                    }
                }

                $gs = Generalsetting::findOrFail(1);
                if(isset($data->customer_email)){
                if($gs->is_smtp == 1)
                {
                    $maildata = [
                        'to' => $data->customer_email,
                        'subject' => 'Your order '.$data->order_number.' is Declined!',
                        'body' => "Hello ".$data->customer_name.","."\n We are sorry for the inconvenience caused. We are looking forward to your next visit.",
                    ];
                $mailer = new GeniusMailer();
                $mailer->sendCustomMail($maildata);
                }
                else
                {
                   $to = $data->customer_email;
                   $subject = 'Your order '.$data->order_number.' is Declined!';
                   $msg = "Hello ".$data->customer_name.","."\n We are sorry for the inconvenience caused. We are looking forward to your next visit.";
                   $headers = "MIME-Version: 1.0" . "\r\n";
                   $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                   $headers .= "From: ".$gs->from_name."<".$gs->from_email.">";
                   mail($to,$subject,$msg,$headers);
                }
            }
    
            }

            $data->update($input);

            if($request->track_text)
            {
                    $title = ucwords($request->status);
                    $ck = OrderTrack::where('order_id','=',$id)->where('title','=',$title)->first();
                    if($ck){
                        $ck->order_id = $id;
                        $ck->title = $title;
                        $ck->text = $request->track_text;
                        $ck->update();  
                    }
                    else {
                        $data = new OrderTrack;
                        $data->order_id = $id;
                        $data->title = $title;
                        $data->text = $request->track_text;
                        $data->save();            
                    }
    
    
            } 


        $order = VendorOrder::where('order_id','=',$id)->update(['status' => $input['status']]);

         //--- Redirect Section          
         $msg = 'Status Updated Successfully.';
         return response()->json($msg);    
         //--- Redirect Section Ends    
    
            }



        //--- Redirect Section          
        $msg = 'Status Updated Successfully.';
        return response()->json($msg);    
        //--- Redirect Section Ends  


    }



    public function pending()
    {
        return view('admin.order.pending');
    }
    public function processing()
    {
        return view('admin.order.processing');
    }
    public function delivered()
    {
        return view('admin.order.delivered');
    }
    public function completed()
    {
        return view('admin.order.completed');
    }
    public function declined()
    {
        return view('admin.order.declined');
    }
    public function show($id)
    {
        $order = Order::findOrFail($id);
        $cart = json_decode($order->cart,true);
        return view('admin.order.details',compact('order','cart'));
    }
    public function invoice($id)
    {
        $order = Order::findOrFail($id);
        $cart = json_decode($order->cart,true);
        return view('admin.order.invoice',compact('order','cart'));
    }
    public function emailsub(Request $request)
    {
        $gs = Generalsetting::findOrFail(1);
        if($gs->is_smtp == 1)
        {
            $data = 0;
            $datas = [
                    'to' => $request->to,
                    'subject' => $request->subject,
                    'body' => $request->message,
            ];

            $mailer = new GeniusMailer();
            $mail = $mailer->sendCustomMail($datas);
            if($mail) {
                $data = 1;
            }
        }
        else
        {
            $data = 0;
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "From: ".$gs->from_name."<".$gs->from_email.">";
            $mail = mail($request->to,$request->subject,$request->message,$headers);
            if($mail) {
                $data = 1;
            }
        }

        return response()->json($data);
    }

    public function printpage($id)
    {
        $order = Order::findOrFail($id);
        $cart = json_decode($order->cart,true);
        return view('admin.order.print',compact('order','cart'));
    }
    public function thermalprintpage($id)
    {
        $order = Order::findOrFail($id);
        $cart = json_decode($order->cart,true);
        return view('admin.order.thermalprintpage',compact('order','cart'));
    }

    public function license(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $cart = json_decode($order->cart,true);
        $cart->items[$request->license_key]['license'] = $request->license;
        $order->cart = utf8_encode(bzcompress(serialize($cart), 9));
        $order->update();       
        $msg = 'Successfully Changed The License Key.';
        return response()->json($msg);
    }

    public function status($id,$status)
    {
        $mainorder = Order::findOrFail($id);

    }


    public function refundIndex()
    {
        
        return view('admin.order.refund.index');
    }

    public function refundDatatables()
    {

        $datas = Refund::get();

                 //--- Integrating This Collection Into Datatables
                 return Datatables::of($datas)
                 ->addColumn('customer_name', function(Refund $data) {
                     $customer_name = $data->order->customer_name;
                     return $customer_name;
                 })
                
                 ->addColumn('pay_amount', function(Refund $data) {
                     return $data->order->currency_sign . round($data->order->pay_amount * $data->order->currency_value , 2);
                 })
                 ->addColumn('details', function(Refund $data) {
                     return $data->message;
                 })
                 ->addColumn('action', function(Refund $data) {
                    $action = '<div class="action-list">';
                     $action .= '<a data-href="' . route('admin-refund-accept',$data->id) . '" data-toggle="modal" data-target="#confirm-delete"> <i class="fas fa-check"></i> Accept</a><a data-href="' . route('admin-refund-reject',$data->id) . '" data-toggle="modal" data-target="#catalog-modal"> <i class="fas fa-trash-alt"></i> Reject</a>';
                     $action .= '</div>';
                     return $action;
                 }) 
                 ->rawColumns(['customer_name',"pay_amount","details",'action'])
                 ->toJson(); //--- Returning Json Data To Client Side
    }


    public function refundAccept($id)
    {
        $data = Refund::findOrFail($id);
        $order = $data->order;
        $order->status = 'refund';
        $user = User::findOrFail($data->user_id);
        $addTotal = $order->pay_amount + $order->wallet_price;
        $user->balance = $user->balance + $addTotal;
        $user->update();
        
        $gs = Generalsetting::findOrFail(1);
        if($gs->is_smtp == 1)
        {
            
            $datas = [
                    'to' => $order->customer_email,
                    'subject' => $gs->title .' Refund Request confirmation',
                    'body' => 'Your refund request is accepted . request order number is :' . $order->order_number . 'Order Pay_amount :' . $order->pay_amount . 'Refund Amount added to your wallet. Please Login In Your Wallet Balance Thank you.' ,
            ];

            $mailer = new GeniusMailer();
            $mail = $mailer->sendCustomMail($datas);
            
        }
        else
        {
            
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "From: ".$gs->from_name."<".$gs->from_email.">";
            $message = 'Your refund request is accepted . request order number is :' . $order->order_number . ' Order Pay_amount :' . $order->pay_amount . ' Refund Amount added to your wallet. Please Login In and check Your Wallet Balance Thank you.';
            $mail = mail($order->customer_email,$gs->website_title .' Refund request confirmation',$message,$headers);
            
        }
        $order->delete();

        $mgs = __('Request accept Successfully');
        return response()->json($mgs);

    }


    public function refundReject($id)
    {
        $data = Refund::findOrFail($id);
        $order = $data->order;
        
        $gs = Generalsetting::findOrFail(1);

        if($gs->is_smtp == 1)
        {
            
            $datas = [
                    'to' => $order->customer_email,
                    'subject' => $gs->title .' Refund Request Rejected',
                    'body' => 'Your refund request is rejected . request order number is :' . $order->order_number
            ];

            $mailer = new GeniusMailer();
            $mail = $mailer->sendCustomMail($datas);
            
        }
        else
        {
            
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "From: ".$gs->from_name."<".$gs->from_email.">";
            $message = 'Your refund request is rejected . request order number is :' . $order->order_number;
            $mail = mail($order->customer_email,$gs->website_title .' Refund request confirmation',$message,$headers);
            
        }
        $data->delete();
        
        $mgs = __('Request reject Successfully');
        return response()->json($mgs);

    }







}