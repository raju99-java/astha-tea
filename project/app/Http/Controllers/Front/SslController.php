<?php

namespace App\Http\Controllers\Front;

use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\Currency;
use App\Models\Generalsetting;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderTrack;
use App\Models\PaymentGateway;
use App\Models\Product;
use App\Models\Reward;
use App\Models\State;
use App\Models\User;
use App\Models\UserNotification;
use App\Models\VendorOrder;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Session;

class SslController extends Controller
{

    public function store(Request $request){
        if (Session::has('currency')) 
            {
                $curr = Currency::find(Session::get('currency'));
            }
        else
            {
                $curr = Currency::where('is_default','=',1)->first();
            }

        if (!Session::has('cart')) {
            return redirect()->route('front.cart')->with('success',"You don't have any product to checkout.");
         }
         $settings = Generalsetting::findOrFail(1);
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
    
    
         $oldCart = Session::get('cart');
         $cart = new Cart($oldCart);
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


        $settings = Generalsetting::findOrFail(1);
        $order = new Order;

        $item_number = Str::random(4).time();
        $item_amount = $request->total;
            $txnid = "SSLCZ_TXN_".uniqid();
            $order['user_id'] = $request->user_id;
            $new_cart = [];
            $new_cart['totalQty'] = $totalQty;
            $new_cart['totalPrice'] = $cart->totalPrice;
            $new_cart['items'] = $cart->items;
            $new_cart = json_encode($new_cart,true);
            $order['cart'] = $new_cart; 
            $order['pay_amount'] = round($item_amount / $curr->value, 2);
            $order['method'] = $request->method;
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
            $order['wallet_price'] = round($request->wallet_price / $curr->value, 2);  
            $order['commission'] = $commission;
            $order['tax'] = Session::get('current_tax');
            if($request->tax_type == 'state_tax'){
                $order['tax_location'] = State::findOrFail($request['tax'])->state;
            }else{
                $order['tax_location'] = Country::findOrFail($request['tax'])->country_name;
            }
                $order['dp'] = $request->dp;
                $order['txnid'] = $txnid; 
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
                    $sub = $val * $settings->affilate_charge;
                    $user = User::findOrFail(Session::get('affilate'));
                    if($user){
                        if($order['dp'] == 1)
                        {
                            $user->affilate_income += $sub;
                            $user->update();
                        }
    
                        $order['affilate_user'] = $user->id;
                        $order['affilate_charge'] = $sub;
                    }
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
                    $x = (string)$prod['stock'];
                        if($x != null)
                        {
                            $product = Product::findOrFail($prod['item']['id']);
                            $product->stock =  $prod['stock'];
                            $product->update();                
                        }
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
                                
                                $gs = Generalsetting::first();
                                if($gs->is_smtp == 1)
                                {
                                    $maildata = [
                                        'to' => $product->user->email,
                                        'subject' => 'Out of Stock Alert!',
                                        'body' => "One of your product is almost out of stock (less or equal to 5).\n<strong>Product Link: </strong> <a target='_blank' href='".url('/').'/'.'item/'.$product->slug."'>".$product->name."</a>",
                                    ];
                                    $mailer = new GeniusMailer();
                                    $mailer->sendCustomMail($maildata);
                                }
                                else
                                {
                                $to = $product->user->email;
                                $subject = 'Out of Stock Alert!';
                                $msg = "One of your product is almost out of stock (less or equal to 5).\n<strong>Product Link: </strong> <a target='_blank' href='".url('/').'/'.'item/'.$product->slug."'>".$product->name."</a>";
                                $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
                                mail($to,$subject,$msg,$headers);
                                }
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
                            if($order->dp == 1){
                                $vorder->user->update(['current_balance' => $vorder->user->current_balance += $prod['price']]);
                            }
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


    //Sending Email To Buyer

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
    //Sending Email To Admin
    if($gs->is_smtp == 1)
    {
        $data = [
            'to' => $gs->header_email,
            'subject' => "New Order Recieved!!",
            'body' => "Hello Admin!<br>Your store has received a new order.<br>Order Number is ".$order->order_number.".Please login to your panel to check. <br>Thank you.",
        ];

        $mailer = new GeniusMailer();
        $mailer->sendCustomMail($data);            
    }
    else
    {
       $to = $gs->from_email;
       $subject = "New Order Recieved!!";
       $msg = "Hello Admin!\nYour store has recieved a new order.\nOrder Number is ".$order->order_number.".Please login to your panel to check. \nThank you.";
        $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
       mail($to,$subject,$msg,$headers);
    }


     
            Session::put('temporder_id',$order->id);
            Session::put('tempcart',$cart);
            Session::forget('cart');
            Session::forget('already');
            Session::forget('coupon');
            Session::forget('coupon_total');
            Session::forget('coupon_total1');
            Session::forget('coupon_percentage');
            Session::forget('cart');

            $gateway_data = PaymentGateway::where('keyword','sslcommerz')->first();
            $gateway = $gateway_data->convertAutoData();
           

            $post_data = array();
            $post_data['store_id'] = $gateway['store_id'];
            $post_data['store_passwd'] = $gateway['store_password'];
            $post_data['total_amount'] = $item_amount;
            $post_data['currency'] = $curr->name;
            $post_data['tran_id'] = $txnid;
            $post_data['success_url'] = action('Front\SslController@notify');
            $post_data['fail_url'] =  action('Front\SslController@cancle');
            $post_data['cancel_url'] =  action('Front\SslController@cancle');
            # $post_data['multi_card_name'] = "mastercard,visacard,amexcard";  # DISABLE TO DISPLAY ALL AVAILABLE
            
            $input = $request->all();
            # CUSTOMER INFORMATION
            $post_data['cus_name'] = $input['name'];
            $post_data['cus_email'] = $input['email'];
            $post_data['cus_add1'] = $input['address'];
            $post_data['cus_city'] = $input['city'];
            $post_data['cus_postcode'] = $input['zip'];
            $post_data['cus_country'] = $input['customer_country'];
            $post_data['cus_phone'] = $input['phone'];
            $post_data['cus_fax'] = $input['phone'];
            
            
         
            # REQUEST SEND TO SSLCOMMERZ
            if($gateway['sandbox_check'] == 1){
                $direct_api_url = "https://sandbox.sslcommerz.com/gwprocess/v3/api.php";
            }
            else{
            $direct_api_url = "https://securepay.sslcommerz.com/gwprocess/v3/api.php";
            }



            
            $handle = curl_init();
            curl_setopt($handle, CURLOPT_URL, $direct_api_url );
            curl_setopt($handle, CURLOPT_TIMEOUT, 30);
            curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($handle, CURLOPT_POST, 1 );
            curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC
            
            
            $content = curl_exec($handle );
            
            $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
            
            
            
            
            if($code == 200 && !( curl_errno($handle))) {
                curl_close( $handle);
                $sslcommerzResponse = $content;
            } else {
                curl_close( $handle);
                return redirect()->back()->with('unsuccess',"FAILED TO CONNECT WITH SSLCOMMERZ API");
                exit;
            }
            
            # PARSE THE JSON RESPONSE
            $sslcz = json_decode($sslcommerzResponse, true );
            




            if(isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL']!="" ) {
            
                    # THERE ARE MANY WAYS TO REDIRECT - Javascript, Meta Tag or Php Header Redirect or Other
                    # echo "<script>window.location.href = '". $sslcz['GatewayPageURL'] ."';</script>";
                echo "<meta http-equiv='refresh' content='0;url=".$sslcz['GatewayPageURL']."'>";
                # header("Location: ". $sslcz['GatewayPageURL']);
                exit;
            } else {
                return redirect()->back()->with('unsuccess',"JSON Data parsing error!");

            }

     }
    
     public function cancle(Request $request){
        $this->code_image();
         return redirect()->route('front.checkout')->with('unsuccess','Payment Cancelled.');
     }
    
    public function notify(Request $request){
    
            $success_url = action('Front\PaymentController@payreturn');
            $cancel_url = action('Front\PaymentController@paycancle');
            $input = $request->all();

            // dd($response);
            if($input['status'] == 'VALID'){

                $order = Order::where('txnid',$input['tran_id'])->first();
                $data['payment_status'] = 'Completed';
                if($order->dp == 1)
                {
                    $data['status'] = 'completed';
                }
                $order->update($data);
    
                if($order->wallet_price != 0)
                {
                    $user = User::find($order->user_id);
                    $user->balance -= $order->wallet_price;
                    $user->update();
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


                return redirect($success_url)->with(['temporder_id' => $order->id,'temporder' => $order]);
            }
            else {
                $order = Order::where('txnid',$input['tran_id'])->first();
                $order->delete();
                return redirect($cancel_url);
            }
    }
}