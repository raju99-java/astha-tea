<?php

namespace App\Http\Controllers\Front;

use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\UserCustomTea;
use App\Models\CustomTea;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\Currency;
use App\Models\Generalsetting;
use App\Models\Notification;
use App\Models\Order;
use App\Models\CustomTeaOrder;
use App\Models\OrderTrack;
use App\Models\Pagesetting;
use App\Models\PaymentGateway;
use App\Models\Pickup;
use App\Models\Product;
use App\Models\Reward;
use App\Models\State;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\UserNotification;
use App\Models\VendorOrder;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Session;
use Validator;

class CustomTeaCheckoutController extends Controller
{


    public function getState($country_id)
    {
      
        $states = State::where('country_id',$country_id)->get();
   
        if(Auth::user()){
            $user_state = Auth::user()->state;
        }else{
            $user_state = 0;
        }

        
        $html_states = '<option value="" > Select State </option>';
        foreach($states as $state){
            if($state->id == $user_state){
                $check = 'selected';
            }else{
               
                $check = '';
            }
            $html_states .= '<option value="'.$state->id.'"   rel="'.$state->country->id.'" '.$check.' >'.$state->state.'</option>';
        }

        return response()->json(["data" => $html_states,"state" => $user_state]);
    }


    public function loadpayment($slug1,$slug2)
    {
        if (Session::has('currency')) {
            $curr = Currency::find(Session::get('currency'));
        }
        else {
            $curr = Currency::where('is_default','=',1)->first();
        }
        $payment = $slug1;
        $pay_id = $slug2;
        $gateway = '';
        if($pay_id != 0) {
            $gateway = PaymentGateway::findOrFail($pay_id);
        }
        return view('load.payment',compact('payment','pay_id','gateway','curr'));
    }

    public function checkout()
    {
        $usercustomtea=UserCustomTea::where('user_id',Auth::user()->id)->first();
         if (empty($usercustomtea)) {
            return redirect()->route('front.customtea')->with('success',"You don't have any product to checkout.");
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
            
            // $voguepay = PaymentGateway::whereKeyword('voguepay')->first();
            // $voguepayData = $voguepay->convertAutoData();

// If a user is Authenticated then there is no problm user can go for checkout

        if(Auth::guard('web')->check())
        {
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
                

           
        return view('front.customteacheckout', [ 'usercustomtea' => $usercustomtea,'totalPrice' => $total,'gateways' => $gateways, 'shipping_cost' => 0, 'curr' => $curr,'shipping_data' => $shipping_data,'paystackData' => $paystackData]);             
        }

        else

        {
            return redirect()->route('front.customtea')->with('success',"Login First go to checkout.");
        }

    }
    public function couponcheck(Request $request)
    {

        $coupon_check_type = [];
        $code = $_GET['code'];
        
        $coupon = Coupon::where('code','=',$code)->first();
        
        if(!$coupon){
            return response()->json(0);  
        }
        $cart = Session::get('cart');
        foreach($cart->items as $item){
           $product = Product::findOrFail($item['item']['id']);
           
           if($coupon->coupon_type == 'category'){
             
            if($product->category_id == $coupon->category){
                $coupon_check_type[] =1;
            }else{
               
                $coupon_check_type[] =0;
            }
           }elseif($coupon->coupon_type == 'sub_category'){
            if($product->subcategory_id == $coupon->sub_category){
                $coupon_check_type[] =1;
                
               
            }else{
                $coupon_check_type[] =0;
            }
           }elseif($coupon->coupon_type == 'child_category'){
            if($product->childcategory_id == $coupon->child_category){
                $coupon_check_type[] =1;
            }else{
                $coupon_check_type[] =0;
            }
           }else{
              
            $coupon_check_type[] =0;
           }
        
        }
        
       


        if(in_array(0,$coupon_check_type)){
            
            return response()->json(0);  
        }

        
        $gs = Generalsetting::findOrFail(1);
        $code = $_GET['code'];
        $total = (float)preg_replace('/[^0-9\.]/ui','',$_GET['total']);
        if(Session::has('is_tax')){
            $xtotal = ($total * Session::get('is_tax')) / 100;
            $total = $total + $xtotal ;
        }
       
        $fnd = Coupon::where('code','=',$code)->get()->count();
        if($fnd < 1)
        {
        return response()->json(0);              
        }
        else{
        $coupon = Coupon::where('code','=',$code)->first();
            if (Session::has('currency')) 
            {
              $curr = Currency::find(Session::get('currency'));
            }
            else
            {
                $curr = Currency::where('is_default','=',1)->first();
            }
        if($coupon->times != null)
        {
            if($coupon->times == "0")
            {
                return response()->json(0);                
            }
        }
        $today = date('Y-m-d');
        $from = date('Y-m-d',strtotime($coupon->start_date));
        $to = date('Y-m-d',strtotime($coupon->end_date));
        if($from <= $today && $to >= $today)
        {
            if($coupon->status == 1)
            {
                $oldCart = Session::has('cart') ? Session::get('cart') : null;
                $val = Session::has('already') ? Session::get('already') : null;
                if($val == $code)
                {
                    return response()->json(2); 
                }
                $cart = new Cart($oldCart);
                if($coupon->type == 0)
                {
                    Session::put('already', $code);
                    $coupon->price = (int)$coupon->price;

                    $oldCart = Session::get('cart');
                    $cart = new Cart($oldCart);

                    $total = $total - $_GET['shipping_cost'];

                    $val = $total / 100;
                    $sub = $val * $coupon->price;
                    $total = $total - $sub;
                    $total = $total + $_GET['shipping_cost'];
                    $data[0] = round($total,2);
                    $data[1] = $code;      
                    $data[2] = round($sub, 2);
                    if($gs->currency_format == 0){
                        $data[0] = $curr->sign.$data[0];
                    }
                    else{
                        $data[0] = $data[0].$curr->sign;
                    }
                    Session::put('coupon', $data[2]);
                    Session::put('coupon_code', $code);
                    Session::put('coupon_id', $coupon->id);
                    Session::put('coupon_total1', $data[0]);
                    Session::forget('coupon_total');
                    $data[0] = round($total,2);
                    $data[1] = $code;      
                    $data[2] = round($sub, 2);
                    $data[3] = $coupon->id;
                    $data[4] = $coupon->price."%";
                    $data[5] = 1;

                    Session::put('coupon_percentage', $data[4]);


                    return response()->json($data);   
                }
                else{
                    Session::put('already', $code);
                    $total = $total - round($coupon->price * $curr->value, 2);
                    $data[0] = round($total,2);
                    $data[1] = $code;
                    $data[2] = round($coupon->price * $curr->value, 2);
                    $data[3] = $coupon->id;
                    if($gs->currency_format == 0){
                        $data[4] = 0;
                        $data[0] = $curr->sign.$data[0];
                    }
                    else{
                        $data[4] = 0;
                        $data[0] = $data[0].$curr->sign;
                    }
                    Session::put('coupon', $data[2]);
                    Session::put('coupon_code', $code);
                    Session::put('coupon_id', $coupon->id);
                    Session::put('coupon_total1', $data[0]);
                    Session::forget('coupon_total');
                    $data[0] = round($total,2);
                    $data[1] = $code;
                    $data[2] = round($coupon->price * $curr->value, 2);
                    $data[3] = $coupon->id;                  
                    $data[5] = 1;

                    Session::put('coupon_percentage', $data[4]);

                    return response()->json($data);              
                }
            }
            else{
                return response()->json(0);   
            }              
        }
        else{
            return response()->json(0);             
            }
        }         
    } 

    public function localpincodecheck()
    {
         $data=[];
         $data['status']='0';
         $zipcode = $_GET['zipcode'];
         $shipping_data  = DB::table('shippings')->where('user_id','=',0)->get();
         if (Session::has('currency')) {
            $curr = Currency::find(Session::get('currency'));
        }
        else {
            $curr = Currency::where('is_default','=',1)->first();
        }
         $data['shipping_charge']=round($shipping_data['1']->price * $curr->value,2);
         $data['shipping_charge_html']=$curr->sign . round($shipping_data['1']->price * $curr->value,2);
        //  print_r($data['shiiping_charge']);
        //  exit;
         if(!empty($zipcode)){
         $datas=Pickup::where('location',$zipcode)->count();
        //  print_r(1);
        //  exit;
         if($datas>0){
            $data['status']='1';
            $data['shipping_charge']=round($shipping_data['0']->price * $curr->value,2);
            $data['shipping_charge_html']='Free';
            return response()->json($data);
         }
         return response()->json($data);
         }
         return response()->json($data);
    } 


    public function cashondelivery(Request $request)
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
                    $user->emai_verified = 'Yes';
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
        $success_url = action('Front\PaymentController@customteapayreturn');
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
        $order['wallet_price'] = round($request->wallet_price / $curr->value, 2);  
        
        $order->save();

        
        if(Auth::check()){
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

    public function gateway(Request $request)
    {

        $input = $request->all();

        $rules = [
            'txn_id4' => 'required',
        ];


        $messages = [
            'required' => 'The Transaction ID field is required.',
        ];

        $validator = Validator::make($input, $rules, $messages);

       if ($validator->fails()) {
            Session::flash('unsuccess', $validator->messages()->first());
            return redirect()->back()->withInput();
       }

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

        $gs = Generalsetting::findOrFail(1);
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
                        $inPrice = $cproduct->price + $gs->fixed_commission + ($cproduct->price/100) * $gs->percentage_commission ;
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
        $success_url = action('Front\PaymentController@payreturn');
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
        $order['tax'] = Session::get('current_tax');
        if($request->tax_type == 'state_tax'){
            $order['tax_location'] = State::findOrFail($request['tax'])->state;
        }else{
            $order['tax_location'] = Country::findOrFail($request['tax'])->country_name;
        }
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
        $order['txnid'] = $request->txn_id4;
        $order['coupon_code'] = $request->coupon_code;
        $order['coupon_discount'] = $request->coupon_discount;
        $order['dp'] = $request->dp;
        $order['commission'] = $commission;
        $order['payment_status'] = "Pending";
        $order['currency_sign'] = $curr->sign;
        $order['currency_value'] = $curr->value;
        $order['vendor_shipping_id'] = $request->vendor_shipping_id;
        $order['vendor_packing_id'] = $request->vendor_packing_id; 
        $order['wallet_price'] = round($request->wallet_price / $curr->value, 2);         
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

        foreach($cart->items as $prod)
        {
            if($prod['item']['user_id'] != 0)
            {
                $vorder =  new VendorOrder;
                $vorder->order_id = $order->id;
                $vorder->user_id = $prod['item']['user_id'];
                $notf[] = $prod['item']['user_id'];
                $vorder->qty = $prod['qty'];
                $vorder->price = $prod['price'];
                $vorder->created_at = Carbon::now();  
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

        Session::put('temporder_id',$order->id);
        Session::put('tempcart',$cart);
        Session::forget('cart');
        Session::forget('already');
        Session::forget('coupon');
        Session::forget('coupon_total');
        Session::forget('coupon_total1');
        Session::forget('coupon_percentage');



        

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


    // Capcha Code Image
    private function  code_image()
    {
        $actual_path = str_replace('project','',base_path());
        $image = imagecreatetruecolor(200, 50);
        $background_color = imagecolorallocate($image, 255, 255, 255);
        imagefilledrectangle($image,0,0,200,50,$background_color);

        $pixel = imagecolorallocate($image, 0,0,255);
        for($i=0;$i<500;$i++)
        {
            imagesetpixel($image,rand()%200,rand()%50,$pixel);
        }

        $font = $actual_path.'assets/front/fonts/NotoSans-Bold.ttf';
        $allowed_letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $length = strlen($allowed_letters);
        $letter = $allowed_letters[rand(0, $length-1)];
        $word='';
        //$text_color = imagecolorallocate($image, 8, 186, 239);
        $text_color = imagecolorallocate($image, 0, 0, 0);
        $cap_length=6;// No. of character in image
        for ($i = 0; $i< $cap_length;$i++)
        {
            $letter = $allowed_letters[rand(0, $length-1)];
            imagettftext($image, 25, 1, 35+($i*25), 35, $text_color, $font, $letter);
            $word.=$letter;
        }
        $pixels = imagecolorallocate($image, 8, 186, 239);
        for($i=0;$i<500;$i++)
        {
            imagesetpixel($image,rand()%200,rand()%50,$pixels);
        }
        session(['captcha_string' => $word]);
        imagepng($image, $actual_path."assets/images/capcha_code.png");
    }



    public function wallet(Request $request)
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
        if (Session::has('currency')) 
        {
            $curr = Currency::find(Session::get('currency'));
        }
        else
        {
            $curr = Currency::where('is_default','=',1)->first();
        }
        $gs = Generalsetting::findOrFail(1);
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        foreach($cart->items as $key => $prod)
        {
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
        $order = new Order;
       
        $success_url = action('Front\PaymentController@payreturn');
     
        $order['user_id'] = $request->user_id;
        $order['cart'] = utf8_encode(bzcompress(serialize($cart), 9)); 
        $order['totalQty'] = $request->totalQty;
        $order['pay_amount'] = round($request->total / $curr->value, 2);
        $order['method'] = $request->method;
        $order['shipping'] = $request->shipping;
        $order['pickup_location'] = $request->pickup_location;
        $order['customer_email'] = $request->email;
        $order['customer_name'] = $request->name;
        $order['shipping_cost'] = $request->shipping_cost;
        $order['packing_cost'] = $request->packing_cost;
        $order['tax'] = Session::get('current_tax');
        if($request->tax_type == 'state_tax'){
            $order['tax_location'] = State::findOrFail($request['tax'])->state;
        }else{
            $order['tax_location'] = Country::findOrFail($request['tax'])->country_name;
        }
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
        $order['dp'] = $request->dp;
        $order['payment_status'] = "Pending";
        $order['currency_sign'] = $curr->sign;
        $order['currency_value'] = $curr->value;
        $order['vendor_shipping_id'] = $request->vendor_shipping_id;
        $order['vendor_packing_id'] = $request->vendor_packing_id;
        $order['wallet_price'] = round($request->wallet_price / $curr->value, 2);

        if($order['dp'] == 1)
        {
            $order['status'] = 'completed';
        }
            if (Session::has('affilate')) 
            {

                $val = $request->total / $curr->value;
                $val = $val / 100;
                $sub = $val * $gs->affilate_charge;
                $user = User::find(Session::get('affilate'));
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
            $user_amount = Auth::user()->balance;
            $pay_amount = $order->wallet_price;
            $sub = $user_amount - $pay_amount;
            Auth::user()->update(['balance' => $sub]);
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

        foreach($cart->items as $prod)
        {
            if($prod['item']['user_id'] != 0)
            {
                $vorder =  new VendorOrder;
                $vorder->order_id = $order->id;
                $vorder->user_id = $prod['item']['user_id'];
                $notf[] = $prod['item']['user_id'];
                $vorder->qty = $prod['qty'];
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

        Session::put('temporder_id',$order->id);
        Session::put('tempcart',$cart);
        Session::forget('cart');

        Session::forget('already');
        Session::forget('coupon');
        Session::forget('coupon_total');
        Session::forget('coupon_total1');
        Session::forget('coupon_percentage');
               

            if ($order->user_id != 0 && $order->wallet_price != 0) {
                $transaction = new Transaction();
                $transaction->txn_number = Str::random(3).substr(time(), 6,8).Str::random(3);
                $transaction->user_id = $order->user_id;
                $transaction->amount = $order->wallet_price;
                $transaction->currency_sign = $order->currency_sign;
                $transaction->currency_code = Currency::where('sign',$order->currency_sign)->first()->name;
                $transaction->currency_value= $order->currency_value;
                $transaction->details = 'Payment Via Wallet';
                $transaction->type = 'minus';
                $transaction->save();
            }

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
           $headers = "MIME-Version: 1.0" . "\r\n";
           $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
           $headers .= "From: ".$gs->from_name."<".$gs->from_email.">";
           mail($to,$subject,$msg,$headers);            
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
           $headers = "MIME-Version: 1.0" . "\r\n";
           $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
           $headers .= "From: ".$gs->from_name."<".$gs->from_email.">";
           mail($to,$subject,$msg,$headers);
        }



        return redirect($success_url);
    }

}
