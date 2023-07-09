<?php

namespace App\Http\Controllers\Front;

use App\Models\Cart;
use App\Models\User;
use App\Models\UserCustomTea;
use App\Models\CustomTea;
use App\Models\Order;
use App\Models\CustomTeaOrder;
use Razorpay\Api\Api;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Currency;
use App\Models\OrderTrack;
use App\Models\VendorOrder;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Classes\GeniusMailer;
use App\Models\Generalsetting;
use App\Models\UserNotification;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Pagesetting;
use App\Models\PaymentGateway;
use App\Models\Reward;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class RazorpayController extends Controller
{

    public function __construct()
    {
        
        $gateway_data = PaymentGateway::where('keyword','razorpay')->first();
        $gateway = $gateway_data->convertAutoData();
       
        $this->keyId = $gateway['key'];
        $this->keySecret = $gateway['secret'];
        $this->displayCurrency = 'INR';

        $this->api = new Api($this->keyId, $this->keySecret);
    }

    public function store(Request $request)
    {
        if($request->pass_check) {
            $users = User::where('email','=',$request->personal_email)->get();
            if(count($users) == 0) {
                if ($request->personal_pass == $request->personal_confirm){
                    $user = new User;
                    $user->name = $request->personal_name; 
                    $user->email = $request->personal_email;   
                    $user->password = bcrypt($request->personal_pass);
                    $token = md5(time().$request->personal_name.$request->personal_email);
                    $user->verification_link = $token;
                    $user->affilate_code = md5($request->name.$request->email);
                    $user->email_verified = 'Yes';
                    $user->save();
                    Auth::guard('web')->login($user);                     
                }else{
                    return redirect()->back()->with('unsuccess',"Confirm Password Doesn't Match.");     
                }
            }
            else {
                return redirect()->back()->with('unsuccess',"This Email Already Exist.");  
            }
        }

        if (!Session::has('cart')) {
            return redirect()->route('front.cart')->with('success',"You don't have any product to checkout.");
        }

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
            if (Session::has('currency')) 
            {
              $curr = Currency::find(Session::get('currency'));
            }
            else
            {
                $curr = Currency::where('is_default','=',1)->first();
            }

            if($curr->name != "INR")
            {
                return redirect()->back()->with('unsuccess','Please Select INR Currency For Rozerpay.');
            }
        $settings = Generalsetting::findOrFail(1);
        $order = new Order;
        $success_url = action('Front\PaymentController@payreturn');
        $item_name = $settings->title." Order";
        $item_number = Str::random(10);
        $item_amount = $request->total;
        $notify_url = action('Front\RazorpayController@razorCallback');
        $cancel_url = action('Front\PaymentController@paycancle');

        $commission = 0;
        $totalQty = 0;
        foreach($cart->items as $key => $prod)
        {
            $totalQty += $prod['qty'];
            if($prod['item']['user_id'] != 0){
                $cproduct = Product::findOrFail($prod['item']['id']);
                if($prod['item']->category->commission != 0){
                    $inPrice = $cproduct->price + $cproduct->price * $prod['item']->category->commission / 100 ;
                }else{
                    $inPrice = $cproduct->price + $settings->fixed_commission + ($cproduct->price/100) * $settings->percentage_commission ;
                }
                $commission += $inPrice - $cproduct->price;
            }
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
                            $oldCart = Session::has('cart') ? Session::get('cart') : null;
                            $cart = new Cart($oldCart);
                            $cart->updateLicense($prod['item']['id'],$license);  
                            Session::put('cart',$cart);
                            break;
                        }                    
                    }
            }
        }



        $orderData = [
            'receipt'         => $item_number,
            'amount'          => $item_amount * 100, // 2000 rupees in paise
            'currency'        => 'INR',
            'payment_capture' => 1 // auto capture
        ];
        
        $razorpayOrder = $this->api->order->create($orderData);
        
        $razorpayOrderId = $razorpayOrder['id'];
        
        session(['razorpay_order_id'=> $razorpayOrderId]);
        
                    $order['user_id'] = $request->user_id;
                    $new_cart = [];
                    $new_cart['totalQty'] = $totalQty;
                    $order['totalQty'] = $totalQty;
                    $new_cart['totalPrice'] = $cart->totalPrice;
                    $new_cart['items'] = $cart->items;
                    $new_cart = json_encode($new_cart,true);
                    $order['cart'] = $new_cart; 
                    $order['pay_amount'] = round($item_amount / $curr->value, 2);
                    $order['method'] = "Razorpay";
                    $order['customer_email'] = $request->email;
                    $order['customer_name'] = $request->name;
                    $order['customer_phone'] = $request->phone;
                    $order['order_number'] = $item_number;
                    $order['shipping'] = $request->shipping;
                    $order['pickup_location'] = $request->pickup_location;
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
                    $order['payment_status'] = "Pending";
                    $order['currency_sign'] = $curr->sign;
                    $order['currency_value'] = $curr->value;
                    $order['shipping_cost'] = $request->shipping_cost;
                    $order['packing_cost'] = $request->packing_cost;
                    $order['tax'] = Session::get('current_tax');
                    $order['commission'] = $commission;
                    if($request->tax_type == 'state_tax'){
                        $order['tax_location'] = State::findOrFail($request['tax'])->state;
                    }else{
                        $order['tax_location'] = Country::findOrFail($request['tax'])->country_name;
                    }
                    $order['wallet_price'] = round($request->wallet_price / $curr->value, 2);  
                    $order['dp'] = $request->dp;
                    $order['vendor_shipping_id'] = $request->vendor_shipping_id;
                    $order['vendor_packing_id'] = $request->vendor_packing_id;
                    
                    if($order['dp'] == 1)
                    {
                        $order['status'] = 'completed';
                    }

                    if (Session::has('affilate')) 
                    {
                        $val = $request->total / $curr->value;
                        $val = $val / 100;
                        $sub = $val * $gs->affilate_charge;
                        $order['affilate_user'] = Session::get('affilate');
                        $order['affilate_charge'] = $sub;
                    }
                    $order->save();

                    if(Auth::check()){
                        if($settings->is_reward == 1){
                            $num = $order->pay_amount;    
                         
                            $rewards = Reward::get();
                            foreach ($rewards as $i) {
                                $smallest[$i->order_amount] = abs($i->order_amount - $num);
                        }
                           
                        asort($smallest);
                           $final_reword = Reward::where('order_amount',key($smallest))->first();
                           Auth::user()->update(['reward' => (Auth::user()->reward + $final_reword->reward)]);
                        }

                        $user_amount = Auth::user()->balance;
                        $pay_amount = $order->wallet_price;
                        $sub = $user_amount - $pay_amount;
                        Auth::user()->update(['balance' => $sub]);
                    }

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

                    if($order->dp == 1){
                        $track = new OrderTrack;
                        $track->title = 'Completed';
                        $track->text = 'Your order has completed successfully.';
                        $track->order_id = $order->id;
                        $track->save();
                    }
                    else {
                        $track = new OrderTrack;
                        $track->title = 'Pending';
                        $track->text = 'You have successfully placed your order.';
                        $track->order_id = $order->id;
                        $track->save();
                    }

                    
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
                                    
                    foreach($cart->items as $prod)
                    {
                        if($prod['item']['user_id'] != 0)
                        {
                            $vorder =  new VendorOrder;
                            $vorder->order_id = $order->id;
                            $vorder->user_id = $prod['item']['user_id'];
                            $notf[] = $prod['item']['user_id'];
                            $vorder->qty = $prod['qty'];
                            $vorder->created_at = Carbon::now();  
                            $vorder->price = $prod['price'];
                            $vorder->order_number = $order->order_number;             
                            $vorder->save();
                        }

                    }

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

                    $gs = Generalsetting::find(1);

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

                    Session::put('tempcart',$cart);
                    Session::forget('cart');
                    

                    $displayAmount = $amount = $orderData['amount'];
                    
                    if ($this->displayCurrency !== 'INR')
                    {
                        $url = "https://api.fixer.io/latest?symbols=$this->displayCurrency&base=INR";
                        $exchange = json_decode(file_get_contents($url), true);
                    
                        $displayAmount = $exchange['rates'][$this->displayCurrency] * $amount / 100;
                    }
                    
                    $checkout = 'automatic';
                    
                    if (isset($_GET['checkout']) and in_array($_GET['checkout'], ['automatic', 'manual'], true))
                    {
                        $checkout = $_GET['checkout'];
                    }
                    
                    $data = [
                        "key"               => $this->keyId,
                        "amount"            => $amount,
                        "name"              => $item_name,
                        "description"       => $item_name,
                        "prefill"           => [
							"name"              => $request->name,
							"email"             => $request->email,
							"contact"           => $request->phone,
                        ],
                        "notes"             => [
							"address"           => $request->address,
							"merchant_order_id" => $item_number,
                        ],
                        "theme"             => [
							"color"             => "{{$settings->colors}}"
                        ],
                        "order_id"          => $razorpayOrderId,
                    ];
                    
                    if ($this->displayCurrency !== 'INR')
                    {
                        $data['display_currency']  = $this->displayCurrency;
                        $data['display_amount']    = $displayAmount;
                    }
                    
                    $json = json_encode($data);
                    $displayCurrency = $this->displayCurrency;
                    
        return view( 'front.razorpay-checkout', compact( 'data','displayCurrency','json','notify_url' ) );
        
    }

    
	public function razorCallback( Request $request ) {


        $success = true;

        $error = "Payment Failed";
        
        if (empty($_POST['razorpay_payment_id']) === false)
        {
            //$api = new Api($keyId, $keySecret);
        
            try
            {
                // Please note that the razorpay order ID must
                // come from a trusted source (session here, but
                // could be database or something else)
                $attributes = array(
                    'razorpay_order_id' => session('razorpay_order_id'),
                    'razorpay_payment_id' => $_POST['razorpay_payment_id'],
                    'razorpay_signature' => $_POST['razorpay_signature']
                );
        
                $this->api->utility->verifyPaymentSignature($attributes);
            }
            catch(SignatureVerificationError $e)
            {
                $success = false;
                $error = 'Razorpay Error : ' . $e->getMessage();
            }
        }
        
        if ($success === true)
        {
            
            $razorpayOrder = $this->api->order->fetch(session('razorpay_order_id'));
        
            $order_id = $razorpayOrder['receipt'];
            $transaction_id = $_POST['razorpay_payment_id'];
            $order = Order::where( 'order_number', $order_id )->first();

            if (isset($order)) {
                $data['txnid'] = $transaction_id;
                $data['payment_status'] = 'Completed';
                if($order->dp == 1)
                {
                    $data['status'] = 'completed';
                }
                $order->update($data);
                $notification = new Notification;
                $notification->order_id = $order->id;
                $notification->save();

                Session::put('temporder_id',$order->id);

            }
            return redirect()->route('payment.return');

        }
        else
        {
            
            return redirect(route('front.checkout'));
        }
        
    }

    public function customteastore(Request $request)
    {
        
        $usercustomtea=UserCustomTea::where('user_id',Auth::user()->id)->first();
         if (empty($usercustomtea)) {
            return redirect()->route('front.customtea')->with('success',"You don't select any custom tea value to checkout.");
        }
        
        if (Session::has('currency')) 
        {
            $curr = Currency::find(Session::get('currency'));
        }
        else
        {
            $curr = Currency::where('is_default','=',1)->first();
        }

        if($curr->name != "INR")
        {
            return redirect()->back()->with('unsuccess','Please Select INR Currency For Razorpay.');
        }
        $settings = Generalsetting::findOrFail(1);
        $order = new CustomTeaOrder;
        $success_url = action('Front\PaymentController@customteapayreturn');
        $item_name = $settings->title." Order";
        $item_number = Str::random(10);
        $item_amount = $request->total;
        $notify_url = action('Front\RazorpayController@customtearazorCallback');
        $cancel_url = action('Front\PaymentController@customteapaycancle');

        $commission = 0;
        $totalQty = 0;
        



        $orderData = [
            'receipt'         => $item_number,
            'amount'          => $item_amount * 100, // 2000 rupees in paise
            'currency'        => 'INR',
            'payment_capture' => 1 // auto capture
        ];
        
        $razorpayOrder = $this->api->order->create($orderData);
        
        $razorpayOrderId = $razorpayOrder['id'];
        
        session(['razorpay_order_id'=> $razorpayOrderId]);
        $smellProduct=CustomTea::where('type','=','1')->where('id',$usercustomtea->smell)->first();
        $colorProduct=CustomTea::where('type','=','2')->where('id',$usercustomtea->color)->first();
        $colorper=$usercustomtea->weight*($usercustomtea->color_per/100);
        $smellper=$usercustomtea->weight*($usercustomtea->smell_per/100);
        $colorprice=$colorper*$colorProduct->price;
        $smellprice=$smellper*$smellProduct->price;
        
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

                    $order['pay_amount'] = round($item_amount / $curr->value, 2);
                    $order['method'] = "Razorpay";
                    $order['customer_email'] = $request->email;
                    $order['customer_name'] = $request->name;
                    $order['customer_phone'] = $request->phone;
                    $order['order_number'] = $item_number;
                    $order['shipping'] = $request->shipping;
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
                    $order['payment_status'] = "Pending";
                    $order['currency_sign'] = $curr->sign;
                    $order['currency_value'] = $curr->value;
                    $order['shipping_cost'] = $request->shipping_cost;
                    $order['wallet_price'] = round($request->wallet_price / $curr->value, 2);  
                    
                    
                    $order->save();
                    if(Auth::check()){
                        // if($settings->is_reward == 1){
                        //     $num = $order->pay_amount;    
                         
                        //     $rewards = Reward::get();
                        //     foreach ($rewards as $i) {
                        //         $smallest[$i->order_amount] = abs($i->order_amount - $num);
                        // }
                           
                        // asort($smallest);
                        //    $final_reword = Reward::where('order_amount',key($smallest))->first();
                        //    Auth::user()->update(['reward' => (Auth::user()->reward + $final_reword->reward)]);
                        // }

                        $user_amount = Auth::user()->balance;
                        $pay_amount = $order->wallet_price;
                        $sub = $user_amount - $pay_amount;
                        Auth::user()->update(['balance' => $sub]);
                    }
                    

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



                    // foreach($cart->items as $prod)
                    // {
                    //     $x = (string)$prod['stock'];
                    //     if($x != null)
                    //     {

                    //         $product = Product::findOrFail($prod['item']['id']);
                    //         $product->stock =  $prod['stock'];
                    //         $product->update();  
                    //         if($product->stock <= 5)
                    //         {
                    //             $notification = new Notification;
                    //             $notification->product_id = $product->id;
                    //             $notification->save();                    
                    //         }              
                    //     }
                    // }

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

                    $gs = Generalsetting::find(1);

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

                    
                    

                    $displayAmount = $amount = $orderData['amount'];
                    
                    if ($this->displayCurrency !== 'INR')
                    {
                        $url = "https://api.fixer.io/latest?symbols=$this->displayCurrency&base=INR";
                        $exchange = json_decode(file_get_contents($url), true);
                    
                        $displayAmount = $exchange['rates'][$this->displayCurrency] * $amount / 100;
                    }
                    
                    $checkout = 'automatic';
                    
                    if (isset($_GET['checkout']) and in_array($_GET['checkout'], ['automatic', 'manual'], true))
                    {
                        $checkout = $_GET['checkout'];
                    }
                    
                    $data = [
                        "key"               => $this->keyId,
                        "amount"            => $amount,
                        "name"              => $item_name,
                        "description"       => $item_name,
                        "prefill"           => [
							"name"              => $request->name,
							"email"             => $request->email,
							"contact"           => $request->phone,
                        ],
                        "notes"             => [
							"address"           => $request->address,
							"merchant_order_id" => $item_number,
                        ],
                        "theme"             => [
							"color"             => "{{$settings->colors}}"
                        ],
                        "order_id"          => $razorpayOrderId,
                    ];
                    
                    if ($this->displayCurrency !== 'INR')
                    {
                        $data['display_currency']  = $this->displayCurrency;
                        $data['display_amount']    = $displayAmount;
                    }
                    
                    $json = json_encode($data);
                    $displayCurrency = $this->displayCurrency;
                    
        return view( 'front.razorpay-checkout', compact( 'data','displayCurrency','json','notify_url' ) );
        
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
      $response = file_get_contents($url);
      return 1;
    }

    public function customtearazorCallback( Request $request ) {


        $success = true;

        $error = "Payment Failed";
        
        if (empty($_POST['razorpay_payment_id']) === false)
        {
            //$api = new Api($keyId, $keySecret);
        
            try
            {
                // Please note that the razorpay order ID must
                // come from a trusted source (session here, but
                // could be database or something else)
                $attributes = array(
                    'razorpay_order_id' => session('razorpay_order_id'),
                    'razorpay_payment_id' => $_POST['razorpay_payment_id'],
                    'razorpay_signature' => $_POST['razorpay_signature']
                );
        
                $this->api->utility->verifyPaymentSignature($attributes);
            }
            catch(SignatureVerificationError $e)
            {
                $success = false;
                $error = 'Razorpay Error : ' . $e->getMessage();
            }
        }
        
        if ($success === true)
        {
            
            $razorpayOrder = $this->api->order->fetch(session('razorpay_order_id'));
        
            $order_id = $razorpayOrder['receipt'];
            $transaction_id = $_POST['razorpay_payment_id'];
            $order = CustomTeaOrder::where( 'order_number', $order_id )->first();

            if (isset($order)) {
                $data['txnid'] = $transaction_id;
                $data['payment_status'] = 'Completed';
                
                $order->update($data);
                $notification = new Notification;
                $notification->order_id = $order->id;
                $notification->save();

                Session::put('temporder_id',$order->id);

            }
            return redirect()->route('customteapayment.return');

        }
        else
        {
            
            return redirect(route('front.customteacheckout'));
        }
        
    }

}
