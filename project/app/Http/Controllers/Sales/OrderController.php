<?php

namespace App\Http\Controllers\Sales;
use Auth;
use Carbon\Carbon;
use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\Generalsetting;
use App\Models\Order;
use App\Models\OrderTrack;
use App\Models\User;
use App\Models\Cart;
use App\Models\VendorOrder;
use App\Models\Product;
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

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sales');
    }

    //*** JSON Request
    public function datatables(Request $request,$status)
    {
        $id = Auth::guard('sales')->user()->id;
        
          $datas = Order::orderBy('id','desc')->where('salesman_id',$id);  
        
         
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('created_at', function(Order $data) {
                                return date('d-M-Y H:i:s a',strtotime($data->created_at));
                            })
                            ->editColumn('order_number', function(Order $data) {
                                $id = $data->order_number;
                                return $id;
                            })
                            ->editColumn('pay_amount', function (Order $data) {
                                return $data->currency_sign . round(($data->pay_amount + $data->wallet_price) * $data->currency_value, 2);
                            })
                            ->addColumn('action', function(Order $data) {

                                return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button><div class="action-list"><a href="' . route('sales-order-show',$data->id) . '" > <i class="fas fa-eye"></i> Details</a></div></div>';
                                
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
        return view('sales.order.index');
    }

    public function total_sold_order()
    {
        $data = [];
        return view('sales.order.total_sold_order',compact('data'));
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

    
    
   
    public function show($id)
    {
        $order = Order::findOrFail($id);
        $cart = json_decode($order->cart,true);
        return view('sales.order.details',compact('order','cart'));
    }
    

    

    public function status($id,$status)
    {
        $mainorder = Order::findOrFail($id);

    }

    public function load(Request $request)
    {
        $prod = Product::where('status','1')->get();
        return view('load.product',compact('prod'));
    }

    public function create()
    {
        $prod = Product::where('status','1')->get();
        $users = User::where('ban', 0)->orderBy('name', 'ASC')->get();
        return view('sales.order.create',compact('users','prod'));
    }

    public function store(Request $request)
        {

            

            //--- Validation Section
            $rules = [
                // 'photo'     => 'mimes:jpeg,jpg,png,svg',
                'user'      => 'required',
                
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
            }
            //--- Validation Section Ends

            //--- Logic Section
            $data = new User;
            $input = $request->all();
            
            Session::forget('user_ids');
            Session::forget('salescart');
            if ($request->product != null){
            
                foreach($request->product as $key1 => $product ){
                                   
                    if (!empty($product)){
                        $prod = Product::where('id','=',$product)->first(['id','user_id','slug','name','photo','size','size_qty','size_price','color','price','stock','type','file','link','license','license_qty','measure','whole_sell_qty','whole_sell_discount','attributes','category_id']);
                        
                        $id=$prod->id;
                        $keys = '';
                        $values = '';
                        
                        // Set Size

                        $size = '';
                        if(!empty($prod->size))
                        { 
                        $size = trim($prod->size[0]);
                        }  
                        $size = str_replace(' ','-',$size);

                        // Set Color

                        $color = '';
                        if(!empty($prod->color))
                        { 
                        $color = $prod->color[0];
                        $color = str_replace('#','',$color);
                        }  

                    
                        

                        if($prod->user_id != 0){
                        $gs = Generalsetting::findOrFail(1);
                        if($prod->category->commission != 0){
                            $comm = ($prod->price * $prod->category->commission) / 100;
                            $prc = $prod->price + $comm;
                        }else{
                            $prc = $prod->price + $gs->fixed_commission + ($prod->price/100) * $gs->percentage_commission ;
                        }
                    
                        $prod->price = round($prc,2);
                        }


                        $keys = rtrim($keys, ',');
                        $values = rtrim($values, ',');
                        
                        $oldCart = Session::has('salescart') ? Session::get('salescart') : null;
                        $cart = new Cart($oldCart);

                        $cart->add($prod, $prod->id, $size ,$color, $keys, $values);

                        if($cart->items[$id.$size.$color.str_replace(str_split(' ,'),'',$values)]['stock'] < 0)
                        {
                            return response()->json(array('errors' => [ 0 => 'Some Product You Selected Is Out Of Stock!!' ])); 
                        }
                        if($cart->items[$id.$size.$color.str_replace(str_split(' ,'),'',$values)]['size_qty'])
                        {
                            if($cart->items[$id.$size.$color.str_replace(str_split(' ,'),'',$values)]['qty'] > $cart->items[$id.$size.$color.str_replace(str_split(' ,'),'',$values)]['size_qty'])
                            {
                                return response()->json(array('errors' => [ 0 => 'Some Product You Selected Is Out Of Stock!!Out Of stock' ])); 
                            }           
                        }

                        $cart->totalPrice = 0;
                        foreach($cart->items as $data)
                        $cart->totalPrice += $data['price'];
                        Session::put('salescart',$cart);

                        
                        
                    }
                }
                // print_r($cart);
                //                 print_r('/'.$qty);
                //                 exit;
            }


            Session::put('user_ids',$request->user);

            // $id = Auth::guard('sales')->user()->id;
            // $input['status'] = '1';
            // $input['registered_by'] = $id;
            // $password=$input['phone'];
            // $input['password'] = Hash::make($password);
            // if ($file = $request->file('photo'))
            // {
            //     $name = time().str_replace(' ', '', $file->getClientOriginalName());
            //     $file->move('assets/images/user',$name);
                
            //     $input['photo'] = $name;
            // }
            


            // // Save Data
            // $data->fill($input)->save();

            

            

            //--- Redirect Section
            $msg = 'Product  Added Successfully.';
            // return response()->json($msg);
            return response()->json(route('sales-order-checkout'));
            //--- Redirect Section Ends
        }

        public function checkout()
        {
            
            if (!Session::has('salescart')) {
                return redirect()->route('sales-order-create')->with('success',"You don't choose any product to checkout.");
            }
            $gs = Generalsetting::findOrFail(1);
            $dp = 1;

            $vendor_shipping_id = 0;
            $vendor_packing_id = 0;
            $user_id=Session::get('user_ids');
            $user=User::where('id',$user_id)->first();

                $curr = Currency::where('is_default','=',1)->first();
                            
                $paystack = PaymentGateway::whereKeyword('paystack')->first();

                $paystackData = $paystack->convertAutoData();
                
                // $voguepay = PaymentGateway::whereKeyword('voguepay')->first();
                // $voguepayData = $voguepay->convertAutoData();
    
            // If a user is Authenticated then there is no problm user can go for checkout
    
            
                $gateways =  PaymentGateway::where('is_checkout','=',1)->get();
                    $pickups = Pickup::all();
                    $oldCart = Session::get('salescart');
                    $cart = new Cart($oldCart);
                    $products = $cart->items;
    
                    
                    $shipping_data  = DB::table('shippings')->where('user_id','=',0)->get();
                    
    
                    // Packaging
    
                    
                    $package_data  = DB::table('packages')->where('user_id','=',0)->get();
                    
    
    
                    foreach ($products as $prod) {
                        if($prod['item']['type'] == 'Physical')
                        {
                            $dp = 0;
                            break;
                        }
                    }
                    if($dp == 1)
                    {
                    $ship  = 0;                    
                    }
                    $total = $cart->totalPrice;
                    $coupon = Session::has('coupon') ? Session::get('coupon') : 0;
                    if($gs->tax != 0)
                    {
                        $tax = ($total / 100) * $gs->tax;
                        $total = $total + $tax;
                    }
                    if(!Session::has('coupon_total'))
                    {
                    $total = $total - $coupon;     
                    $total = $total + 0;               
                    }
                    else {
                    $total = Session::get('coupon_total');  
                    $total = $total; 
                    }
    
               
            return view('sales.order.checkout', ['products' => $cart->items, 'totalPrice' => $total, 'pickups' => $pickups, 'totalQty' => $cart->totalQty, 'gateways' => $gateways, 'shipping_cost' => 0, 'digital' => $dp, 'curr' => $curr,'shipping_data' => $shipping_data,'package_data' => $package_data, 'vendor_shipping_id' => $vendor_shipping_id, 'vendor_packing_id' => $vendor_packing_id,'paystackData' => $paystackData,'user' => $user]);             
            
    
        }
        public function walletcheck()
    {

        if (Session::has('currency')) 
        {
          $curr = Currency::find(Session::get('currency'));
        }
        else
        {
            $curr = Currency::where('is_default','=',1)->first();
        }
        $user=User::where('id',$_GET['user_id'])->first();

        $shipping_cost = (double)$_GET['shipping_cost'];
        $amount = (double)$_GET['code'];
        $total = (double)$_GET['total'];
        $prev_price = (double)$_GET['prev_price'];
        $balance = $user->balance * $curr->value;
        $total_price = $amount + $prev_price;
        if($total_price <= $balance){
            if($amount > 0 && $amount <= $total){
                $total -= $amount;
                $data[0] = $total+$shipping_cost;
                $data[2] = $total;
                $data[1]  = $amount;
                return response()->json($data);
            }else {
                return response()->json(0);

            }
        }else{
            return response()->json(1);
        }

    }
    public function payreturn(Request $request){
    
        // $this->code_image();
        // print_r(1);
        // exit;
        if(Session::has('salestempcart')){
        $oldCart = Session::get('salestempcart');
        $tempcart = new Cart($oldCart);
        $order = Order::findOrFail(Session::get('salestemporder_id'));
        }

        else{
            $tempcart = '';
            return redirect()->back();
        }
        Session::forget('salescart');
        
        return view('sales.order.conform',compact('tempcart','order'));
     }

    public function cashondelivery(Request $request)
    {
        

        
        if (!Session::has('salescart')) {
            return redirect()->route('sales-order-create')->with('success',"You don't choose any product to checkout.");
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
        $oldCart = Session::get('salescart');
        $cart = new Cart($oldCart);
        $commission = 0;
        $totalQty = 0;
        foreach($cart->items as $key => $prod)
        {
            $totalQty += $prod['qty'];
            // if($prod['item']['user_id'] != 0){
            //     $cproduct = Product::findOrFail($prod['item']['id']);
            //     if($prod['item']->category->commission != 0){
            //         $inPrice = $cproduct->price + $cproduct->price * $prod['item']->category->commission / 100 ;
            //     }else{
            //         $inPrice = $cproduct->price + $gs->fixed_commission + ($cproduct->price/100) * $gs->percentage_commission ;
            //     }
            //     $commission += $inPrice - $cproduct->price;
            // }
        if(!empty($prod['item']['license']) && !empty($prod['item']['license_qty']))
        {
                foreach($prod['item']['license_qty']as $ttl => $dtl)
                {
                    if($dtl != 0)
                    {
                        $dtl--;
                        $produc = Product::findOrFail($prod['item']['id']);
                        $temp = $produc->license_qty;
                        $temp[$ttl] = $dtl;
                        $final = implode(',', $temp);
                        $produc->license_qty = $final;
                        $produc->update();
                        $temp =  $produc->license;
                        $license = $temp[$ttl];
                         $oldCart = Session::has('salescart') ? Session::get('salescart') : null;
                         $cart = new Cart($oldCart);
                         $cart->updateLicense($prod['item']['id'],$license);  
                         Session::put('salescart',$cart);
                        break;
                    }                    
                }
        }
        }
        
        $order = new Order;
        $success_url = action('Sales\OrderController@payreturn');
        
        $item_name = $gs->title." Order";
        $item_number = Str::random(10);
        $order['user_id'] = $request->user_id;
        $new_cart = [];
        $new_cart['totalQty'] = $totalQty;
        $order['totalQty'] = $totalQty;
        $new_cart['totalPrice'] = $cart->totalPrice;
        $new_cart['items'] = $cart->items;
        $new_cart = json_encode($new_cart,true);
        $order['cart'] = $new_cart;
        $order['pay_amount'] = round($request->total / $curr->value, 2);
        $order['method'] = $request->method;
        $order['shipping'] = $request->shipping;
        $order['pickup_location'] = $request->pickup_location;
        $order['customer_email'] = $request->email;
        $order['customer_name'] = $request->name;
        $order['shipping_cost'] = $request->shipping_cost;
        $order['packing_cost'] = $request->packing_cost;
        // $order['tax'] = Session::get('current_tax');
        // if($request->tax_type == 'state_tax'){
        //     $order['tax_location'] = State::findOrFail($request['tax'])->state;
        // }else{
        //     $order['tax_location'] = Country::findOrFail($request['tax'])->country_name;
        // }
        $order['tax_location'] = 'India';
        $order['customer_phone'] = $request->phone;
        $order['order_number'] = Str::random(10);
        $order['customer_address'] = $request->address;
        $order['customer_country'] = $request->customer_country;
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
        $order['dp'] = $request->dp;
        $order['commission'] = $commission;
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
        
        
        if(Auth::check()){}
        $user_id = $request->user_id;
        $user=User::where('id',$user_id)->first();
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


        $track = new OrderTrack;
        $track->title = 'Pending';
        $track->text = 'You have successfully placed your order.';
        $track->order_id = $order->id;
        $track->save();

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

        foreach($cart->items as $prod)
        {
            $x = (string)$prod['size_qty'];
            if(!empty($x))
            {
                $product = Product::findOrFail($prod['item']['id']);
                $x = (int)$x;
                $x = $x - $prod['qty'];
                $temp = $product->size_qty;
                $temp[$prod['size_key']] = $x;
                $temp1 = implode(',', $temp);
                $product->size_qty =  $temp1;
                $product->update();               
            }
        }


        foreach($cart->items as $prod)
        {
            $x = (string)$prod['stock'];
            if($x != null)
            {

                $product = Product::findOrFail($prod['item']['id']);
                $product->stock =  $prod['stock'];
                $product->update();  
                if($product->stock <= 5)
                {
                    $notification = new Notification;
                    $notification->product_id = $product->id;
                    $notification->save();                    
                }              
            }
        }

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

            Session::put('salestemporder_id',$order->id);
            Session::put('salestempcart',$cart);
            Session::forget('salescart');
            // Session::forget('already');
            Session::forget('coupon');
            Session::forget('coupon_total');
            Session::forget('coupon_total1');
            Session::forget('coupon_percentage');

        // $message = 'Your OTP for Registration is 1230 Regards Printmont.';
        $message = 'Hi '.$request->name.', Your purchase of Rs/- '.$cart->totalPrice.' is confirmed. Visit again https://asthatea.com Thank you.';
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





}