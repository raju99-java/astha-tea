<?php

namespace App\Http\Controllers\Sales;
use Auth;
use Carbon\Carbon;
use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\Generalsetting;
use App\Models\CustomTeaOrder;
use App\Models\OrderTrack;
use App\Models\User;
use App\Models\VendorOrder;
use App\Models\CustomTea;
use App\Models\UserCustomTea;
use App\Models\Refund;
use App\Models\Pickup;
use App\Models\Currency;
use App\Models\PaymentGateway;
use App\Models\DeliveryBoy;
use App\Models\SalesPerson;
use App\Models\Country;
use App\Models\Notification;
use App\Models\Pagesetting;
use Illuminate\Support\Str;
use DB;
use Session;
use Datatables;
use Validator;
use Illuminate\Http\Request;

class CustomTeaOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sales');
    }

    public function datatables(Request $request,$status)
    {
        $id = Auth::guard('sales')->user()->id;
        
          $datas = CustomTeaOrder::orderBy('id','desc')->where('salesman_id',$id);  
        
         
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('created_at', function(CustomTeaOrder $data) {
                                return date('d-M-Y H:i:s a',strtotime($data->created_at));
                            })
                            ->editColumn('order_number', function(CustomTeaOrder $data) {
                                $id = $data->order_number;
                                return $id;
                            })
                            ->editColumn('pay_amount', function (CustomTeaOrder $data) {
                                return $data->currency_sign . round(($data->pay_amount + $data->wallet_price) * $data->currency_value, 2);
                            })
                            ->addColumn('action', function(CustomTeaOrder $data) {

                                return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button><div class="action-list"><a href="' . route('sales-customtea-order-show',$data->id) . '" > <i class="fas fa-eye"></i> Details</a></div></div>';
                                
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
                                        $w->orWhere('customer_phone', 'LIKE', "%$search%")
                                        ->orWhere('order_number', 'LIKE', "%$search%")
                                        ->orWhere('method', 'LIKE', "%$search%")
                                        ->orWhere('pay_amount', 'LIKE', "%$search%");
                                    });
                                }
                            })
                            ->rawColumns(['id','action','order_number'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }
    
    public function index()
    {
        return view('sales.customteaorder.index');
    }
    
    
    
    public function show($id)
    {
        $order = CustomTeaOrder::findOrFail($id);
        return view('sales.customteaorder.details',compact('order'));
    }
    


    public function status($id,$status)
    {
        $mainorder = CustomTeaOrder::findOrFail($id);

    }


    public function create()
    {       
        $smell = CustomTea::where('type','=','1')->orderBy('id','desc')->where('status','1')->get();
        $color = CustomTea::where('type','=','2')->orderBy('id','desc')->where('status','1')->get();
        $users = User::where('ban', 0)->orderBy('name', 'ASC')->get();
        return view('sales.customteaorder.create',compact('users','smell','color'));
    }

    public function store(Request $request)
    {

        

        //--- Validation Section
        $rules = [
            // 'photo'     => 'mimes:jpeg,jpg,png,svg',
            'user'      => 'required',
            'weight'    => 'required',
            'color'    => 'required',
            'smell'    => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends
        Session::forget('customtea_user_ids');
        //--- Logic Section
        $data = new UserCustomTea;
        $sign = Currency::where('is_default','=',1)->first();
        $input = $request->all();
        $smell=$request->smell;
        $color = $request->color;
        $weight = $request->weight;
        $smellProduct=CustomTea::where('type','=','1')->where('id',$smell)->first();
        $colorProduct=CustomTea::where('type','=','2')->where('id',$color)->first();
        $colorper=$weight*($request->color_per/100);
        $smellper=$weight*($request->smell_per/100);
        $colorprice=$colorper*$colorProduct->price;
        $smellprice=$smellper*$smellProduct->price;
        $total=$colorprice+$smellprice;
        if($smellProduct->stock <= $smellper)
          {
            // Auth::guard('web')->logout();
            return response()->json(array('errors' => [ 0 => 'Smell Component Stock Not Available!' ]));   
          }
          if($colorProduct->stock <= $colorper)
          {
            // Auth::guard('web')->logout();
            return response()->json(array('errors' => [ 0 => 'Colour Component Stock Not Available!' ]));   
          }

          $input['user_id'] = $request->user;
        
        $input['price'] = ($total / $sign->value);
        $check=UserCustomTea::where('user_id',$request->user)->first();
        // Save Data
        if(empty($check)){
        $data->fill($input)->save();
        }else{
          $check->update($input);
        }
        

        Session::put('customtea_user_ids',$request->user);
        


        
        $msg = 'Product  Added Successfully.';
        // return response()->json($msg);
        return response()->json(route('sales-customtea-order-checkout'));
        //--- Redirect Section Ends
    }
    public function checkout()
    {
        $user_id=Session::get('customtea_user_ids');
        $user=User::where('id',$user_id)->first();
        $usercustomtea=UserCustomTea::where('user_id',$user_id)->first();
         if (empty($usercustomtea)) {
                return redirect()->route('sales-customtea-order-create')->with('success',"User Not Having A Custom Tea Composition.");
        }
        $gs = Generalsetting::findOrFail(1);
        $dp = 1;
        $vendor_shipping_id = 0;
        $vendor_packing_id = 0;
            if (Session::has('currency')) 
            {
              $curr = Currency::find(Session::get('currency'));
            }
            else
            {
                $curr = Currency::where('is_default','=',1)->first();
            }

            $paystack = PaymentGateway::whereKeyword('paystack')->first();
            $paystackData = $paystack->convertAutoData();
            
       
            $gateways =  PaymentGateway::where('is_checkout','=',1)->get();
                $pickups = Pickup::all();

                // Shipping Method

                
                $shipping_data  = DB::table('shippings')->where('user_id','=',0)->get();
                

                


                
                
                $total = $usercustomtea->price;
                $coupon = Session::has('coupon') ? Session::get('coupon') : 0;
                
                if(!Session::has('coupon_total'))
                {
                $total = $total - $coupon;     
                $total = $total + 0;               
                }
                else {
                $total = Session::get('coupon_total');  
                $total = $total; 
                }
                

           
        return view('sales.customteaorder.checkout', [ 'usercustomtea' => $usercustomtea,'totalPrice' => $total,'gateways' => $gateways, 'shipping_cost' => 0, 'curr' => $curr,'shipping_data' => $shipping_data,'paystackData' => $paystackData,'user' => $user]);             
        

    }
   

    public function usercustomteacheck()
    {
         $data=[];
         $data['status']='0';
         $user_id = $_GET['user_id'];
         $user=User::where('id',$user_id)->first();
         $usercustomtea=UserCustomTea::where('user_id',$user_id)->first();
         if(empty($usercustomtea)){
            return response()->json($data);
         }else{
            $data['smell']=$usercustomtea->smell;
            $data['color']=$usercustomtea->color;
            $data['weight']=$usercustomtea->weight;
            $data['smell_per']=$usercustomtea->smell_per;
            $data['color_per']=$usercustomtea->color_per;
            $data['price']=$usercustomtea->price;
            $data['status']='1';
            return response()->json($data);
         }
         
    } 


    public function cashondelivery(Request $request)
    {
       
        $user_id=Session::get('customtea_user_ids');
        $user=User::where('id',$user_id)->first();

        $usercustomtea=UserCustomTea::where('user_id',$user_id)->first();
         if (empty($usercustomtea)) {
            return redirect()->route('sales-customtea-order-create')->with('success',"User Not Having A Custom Tea Composition.");
        }
        if (Session::has('currency')) 
        {
            $curr = Currency::find(Session::get('currency'));
        }
        else
        {
            $curr = Currency::where('is_default','=',1)->first();
        }
        $gs = Generalsetting::findOrFail(1);
        $commission = 0;
        $totalQty = 0;
        

        $smellProduct=CustomTea::where('type','=','1')->where('id',$usercustomtea->smell)->first();
        $colorProduct=CustomTea::where('type','=','2')->where('id',$usercustomtea->color)->first();
        $colorper=$usercustomtea->weight*($usercustomtea->color_per/100);
        $smellper=$usercustomtea->weight*($usercustomtea->smell_per/100);
        $colorprice=$colorper*$colorProduct->price;
        $smellprice=$smellper*$smellProduct->price;

        $order = new CustomTeaOrder;
        $success_url = action('Sales\CustomTeaOrderController@payreturn');
        $item_name = $gs->title." Order";
        $item_number = Str::random(10);
        $order['user_id'] = $request->user_id;
        $order['order_type'] = 'online';
        $order['p1'] = $usercustomtea->smell;
        $order['p1_percent'] = $usercustomtea->smell_per;
        $order['p1_price'] = $smellprice;
        $order['p1_weight'] = $smellper;

        $order['p2'] = $usercustomtea->color;
        $order['p2_percent'] = $usercustomtea->color_per;
        $order['p2_price'] = $colorprice;
        $order['p2_weight'] = $colorper;
        
        $order['total_price'] = $usercustomtea->price;
        $order['totalweight'] = $usercustomtea->weight;

        $order['pay_amount'] = round($request->total / $curr->value, 2);
        $order['method'] = $request->method;
        $order['shipping'] = $request->shipping;
        $order['customer_email'] = $request->email;
        $order['customer_name'] = $request->name;
        $order['shipping_cost'] = $request->shipping_cost;
        $order['customer_phone'] = $request->phone;
        $order['order_number'] = Str::random(10);
        $order['customer_address'] = $request->address;
        // $order['customer_country'] = $request->customer_country;
        $order['customer_city'] = $request->city;
        $order['customer_zip'] = $request->zip;
        $order['shipping_email'] = $request->shipping_email;
        $order['shipping_name'] = $request->shipping_name;
        $order['shipping_phone'] = $request->shipping_phone;
        $order['shipping_address'] = $request->shipping_address;
        $order['shipping_country'] = $request->shipping_country;
        $order['shipping_city'] = $request->shipping_city;
        $order['shipping_zip'] = $request->shipping_zip;
        $order['order_note'] = $request->order_notes;
        $order['coupon_code'] = $request->coupon_code;
        $order['coupon_discount'] = $request->coupon_discount;
        $order['order_type'] = $request->order_type;
        $order['customer_country'] = 'India';
        $order['salesman_id'] = Auth::guard('sales')->user()->id;
        if($request->order_type=='Online'){
            $order['payment_status'] = "Pending";
        }else{
            $order['payment_status'] = "Completed";
        }
        $order['currency_sign'] = $curr->sign;
        $order['currency_value'] = $curr->value;
        $order['wallet_price'] = round($request->wallet_price / $curr->value, 2);  
        
        $order->save();


        if($order->order_type=='Offline'){

            $user->balance = $user->balance + (($order->pay_amount+$order->wallet_price+$order->shipping_cost)*($gs->customer_cashback/100));
            $user->save();
        }
        $salesman=SalesPerson::where('id',Auth::guard('sales')->user()->id)->where('status','1')->where('ban','0')->first();
        if( $salesman ){
            $salesman->commission = $salesman->commission + (($order->pay_amount+$order->wallet_price+$order->shipping_cost)*($gs->sales_person_commission/100));
            $salesman->save();
        }
     
            // if($gs->is_reward == 1){
            //     $num = $order->pay_amount;    
             
            //     $rewards = Reward::get();
            //     foreach ($rewards as $i) {
            //         $smallest[$i->order_amount] = abs($i->order_amount - $num);
            // }
               
            // asort($smallest);
            //    $final_reword = Reward::where('order_amount',key($smallest))->first();
            //    Auth::user()->update(['reward' => (Auth::user()->reward + $final_reword->reward)]);
            // }

            $user_amount = $user->balance;
            $pay_amount = $order->wallet_price;
            $sub = $user_amount - $pay_amount;
            $user->update(['balance' => $sub]);
        

        if ($order->user_id != 0 && $order->wallet_price != 0) {
            $transaction = new \App\Models\Transaction;
            $transaction->txn_number = Str::random(3).substr(time(), 6,8).Str::random(3);
            $transaction->user_id = $order->user_id;
            $transaction->amount = $order->wallet_price;
            $transaction->currency_sign = $order->currency_sign;
            $transaction->currency_code = \App\Models\Currency::where('sign',$order->currency_sign)->first()->name;
            $transaction->currency_value= $order->currency_value;
            $transaction->details = 'Payment Via Wallet';
            $transaction->type = 'minus';
            $transaction->save();
        }


        // $track = new OrderTrack;
        // $track->title = 'Pending';
        // $track->text = 'You have successfully placed your order.';
        // $track->order_id = $order->id;
        // $track->save();

        $notification = new Notification;
        $notification->order_id = $order->id;
        $notification->save();
        if($request->coupon_id != "")
        {
            $coupon = Coupon::findOrFail($request->coupon_id);
            $coupon->used++;
            if($coupon->times != null)
            {
                $i = (int)$coupon->times;
                $i--;
                $coupon->times = (string)$i;
            }
            $coupon->update();

        }

        $smellProduct->stock= $smellProduct->stock-$smellper;
        $colorProduct->stock= $colorProduct->stock-$colorper;
        $smellProduct->update();
        $colorProduct->update();

        


        

        $notf = null;

        

        if(!empty($notf))
        {
            $users = array_unique($notf);
            foreach ($users as $user) {
                $notification = new UserNotification;
                $notification->user_id = $user;
                $notification->order_number = $order->order_number;
                $notification->save();    
            }
        }

            Session::put('temporder_id',$order->id);
            Session::forget('already');
            Session::forget('coupon');
            Session::forget('coupon_total');
            Session::forget('coupon_total1');
            Session::forget('coupon_percentage');

        // $message = 'Your OTP for Registration is 1230 Regards Printmont.';
        $message = 'Hi '.$request->name.', Your purchase of Rs/- '.$usercustomtea->price.' is confirmed. Visit again https://asthatea.com Thank you.';
        $templateid = "1507165959612995097";
        $this->send_sms($request->phone,$message,$templateid);    
        //Sending Email To Buyer
        if(isset($request->email)){
        if($gs->is_smtp == 1)
        {
        $data = [
            'to' => $request->email,
            'type' => "new_order",
            'cname' => $request->name,
            'oamount' => "",
            'aname' => "",
            'aemail' => "",
            'wtitle' => "",
            'onumber' => $order->order_number,
        ];

        $mailer = new GeniusMailer();
        $mailer->sendAutoOrderMail($data,$order->id);            
        }
        else
        {
           $to = $request->email;
           $subject = "Your Order Placed!!";
           $msg = "Hello ".$request->name."!\nYou have placed a new order.\nYour order number is ".$order->order_number.".Please wait for your delivery. \nThank you.";
            $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
           mail($to,$subject,$msg,$headers);            
        }
    }
        //Sending Email To Admin
        if($gs->is_smtp == 1)
        {
            $data = [
                'to' => Pagesetting::find(1)->contact_email,
                'subject' => "New Order Recieved!!",
                'body' => "Hello Admin!<br>Your store has received a new order.<br>Order Number is ".$order->order_number.".Please login to your panel to check. <br>Thank you.",
            ];

            $mailer = new GeniusMailer();
            $mailer->sendCustomMail($data);            
        }
        else
        {
           $to = Pagesetting::find(1)->contact_email;
           $subject = "New Order Recieved!!";
           $msg = "Hello Admin!\nYour store has recieved a new order.\nOrder Number is ".$order->order_number.".Please login to your panel to check. \nThank you.";
            $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
           mail($to,$subject,$msg,$headers);
        }

        return redirect($success_url);
    }
    function send_sms($mob_no, $content, $template_id) {
      $content = urlencode($content);
      // Account details
      $username = 'asthatea';
      $apiKey = '2FA62-60C76';
      $apiRequest = 'Text';
      // Message details
      $sender = 'TASTHA';
      // Route details
      $apiRoute = 'OTP';
      // Prepare data for POST request
      $data = 'username='.$username.'&apikey='.$apiKey.'&apirequest='.$apiRequest.'&route='.$apiRoute.'&mobile='.$mob_no.'&sender='.$sender."&TemplateID=".$template_id."&message=".$content;
      // Send the GET request with cURL
      $url = 'http://sms.dialtext.com/sms-panel/api/http/index.php?'.$data;
      $url = preg_replace("/ /", "%20", $url);
      //print_r($url);
      //exit;
      $arrContextOptions=array(
        "ssl"=>array(
             "verify_peer"=>false,
             "verify_peer_name"=>false,
        ),
      );  
      $response = file_get_contents($url, false, stream_context_create($arrContextOptions));
      return 1;
    }
    

    public function payreturn(Request $request){
    
        // print_r(1);
        // exit;
        Session::forget('customtea_user_ids');
        
        return view('sales.customteaorder.conform');
     }





}