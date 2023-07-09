<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\GeniusMailer;
use App\Models\Generalsetting;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserSubscription;
use Auth;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use App\Models\Currency;
use App\Models\PaymentGateway;
use MercadoPago;

class MercadopagoController extends Controller
{
    public function store(Request $request) {

        $user = Auth::user();
        $package = $user->subscribes()->where('status',1)->orderBy('id','desc')->first();
        $subs = Subscription::findOrFail($request->subs_id);
        $settings = Generalsetting::findOrFail(1);
        $today = Carbon::now()->format('Y-m-d');

        if (Session::has('currency'))
        {
            $curr = Currency::find(Session::get('currency'));
        }
        else
        {
            $curr = Currency::where('is_default','=',1)->first();
        }

    $available_currency = array(
        'BRL',
        'MXN',
        'USD'
        );

        if(!in_array($curr->name,$available_currency))
        {
            return redirect()->back()->with('unsuccess','Invalid Currency For Mercadopago.');
        }


         $settings = Generalsetting::findOrFail(1);

         $return_url = action('User\PaypalController@payreturn');
         $cancel_url = action('User\PaypalController@paycancle');
         $item_amount = round($subs->price * $curr->value,2);
         $gateway_data = PaymentGateway::where('keyword','mercadopago')->first();
         $gateway = $gateway_data->convertAutoData();
        
 
         MercadoPago\SDK::setAccessToken($gateway['token']);
         $payment = new MercadoPago\Payment();
         $payment->transaction_amount = round($item_amount * $curr->value,2);
         $payment->token = $request->token;
         $payment->description = 'Subscription';
         $payment->installments = 1;

         $payment->payer = array(
            "email" => Auth::user()->email,
        );  
            
        $payment->save();

        if ($payment->status == 'approved') {
            $today = Carbon::now()->format('Y-m-d');
            $date = date('Y-m-d', strtotime($today.' + '.$subs->days.' days'));
            $input = $request->all();  
            $user->is_vendor = 2;
            if(!empty($package))
            {
                if($package->subscription_id == $request->subs_id)
                {
                    $newday = strtotime($today);
                    $lastday = strtotime($user->date);
                    $secs = $lastday-$newday;
                    $days = $secs / 86400;
                    $total = $days+$subs->days;
                    $user->date = date('Y-m-d', strtotime($today.' + '.$total.' days'));
                }
                else
                {
                    $user->date = date('Y-m-d', strtotime($today.' + '.$subs->days.' days'));
                }
            }
            else
            {
                $user->date = date('Y-m-d', strtotime($today.' + '.$subs->days.' days'));
            }
            $user->mail_sent = 1;     
            $user->update($input);
            $sub = new UserSubscription;
            $sub->user_id = $user->id;
            $sub->subscription_id = $subs->id;
            $sub->title = $subs->title;
            $sub->currency = $curr->sign;
            $sub->currency_code = $curr->name;
            $sub->price = round($subs->price*$curr->value,2);
            $sub->days = $subs->days;
            $sub->allowed_products = $subs->allowed_products;
            $sub->details = $subs->details;
            $sub->method = 'Mercadopago';
            $sub->txnid = $payment->id;
            $sub->status = 1;
            $sub->save();

            if($settings->is_smtp == 1)
            {
            $data = [
                'to' => $user->email,
                'type' => "vendor_accept",
                'cname' => $user->name,
                'oamount' => "",
                'aname' => "",
                'aemail' => "",
                'onumber' => "",
            ];
            $mailer = new GeniusMailer();
            $mailer->sendAutoMail($data);        
            }
            else
            {
                $headers = "From: ".$settings->from_name."<".$settings->from_email.">";
                mail($user->email,'Your Vendor Account Activated','Your Vendor Account Activated Successfully. Please Login to your account and build your own shop.',$headers);
            }
            return redirect($return_url);
        }
        else{
            return redirect($cancel_url);
        }
        
    }




}
