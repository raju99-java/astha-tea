<?php

namespace App\Http\Controllers\User;

use App\{
    Models\Subscription,
    Classes\GeniusMailer,
    Models\UserSubscription,
    Models\PaymentGateway
};
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Generalsetting;
use Illuminate\Support\Facades\Session;
use Auth;

class SubscriptionController extends Controller
{

    public function package()
    {
        if (Session::has('currency')) {
            $curr = Currency::find(Session::get('currency'));
        }
        else {
            $curr = Currency::where('is_default','=',1)->first();
        }
        $data['curr'] = $curr;
        $data['user'] = Auth::user();
        $data['subs'] = Subscription::all();
        $data['package'] = $this->user->subscribes()->where('status',1)->latest('id')->first();
        return view('user.package.index',$data);
    }

    public function vendorrequest($id)
    {

        if (Session::has('currency')) {
            $curr = Currency::find(Session::get('currency'));
        }
        else {
            $curr = Currency::where('is_default','=',1)->first();
        }
        $user = Auth::user();
        $data['curr'] = $curr;
        $data['subs'] = Subscription::findOrFail($id);
        $data['user'] = $user;
        $data['package'] = $user->subscribes()->where('status',1)->latest('id')->first();
        $gs = Generalsetting::findOrFail(1);
        if($gs->reg_vendor != 1)
        {
            return redirect()->back();
        }

        $data['gateway'] = PaymentGateway::whereIsSubscription(1)->latest('id')->get();
        $paystackData = PaymentGateway::whereKeyword('paystack')->first();
        $data['paystack'] = $paystackData->convertAutoData();
        $voguepayData = PaymentGateway::whereKeyword('voguepay')->first();
        $data['voguepay'] = $voguepayData->convertAutoData();

        return view('user.package.details',$data);
    }

    public function vendorrequestsub(Request $request)
    {
        $input = $request->all();  
        if(isset($input['method'])){
            return redirect()->back();
        }
        $this->validate($request, [
            'shop_name'   => 'unique:users',
           ],[ 
               'shop_name.unique' => __('This shop name has already been taken.')
            ]);

            if(\DB::table('pages')->where('slug',$request->shop_name)->exists())
            {
                return redirect()->back()->with('unsuccess',__('This shop name has already been taken.'));    
            }

            $success_url = route('user.payment.return');
            $user = $this->user;
            $subs = Subscription::findOrFail($request->subs_id);

            $user->is_vendor = 2;
            $user->date = date('Y-m-d', strtotime(Carbon::now()->format('Y-m-d').' + '.$subs->days.' days'));
            $user->mail_sent = 1;     
            $user->update($input);

            $sub = new UserSubscription;
            $data = json_decode(json_encode($subs), true);
            $data['user_id'] = $user->id;
            $data['subscription_id'] = $subs->id;
            $data['method'] = 'Free';
            $data['status'] = 1;
            $sub->fill($data)->save();

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
                
            return redirect($success_url)->with('success',__('Vendor Account Activated Successfully'));

    }

    public function paycancle(){
        return redirect()->back()->with('unsuccess',__('Payment Cancelled.'));
    }

    public function payreturn(){
        return redirect()->route('user-dashboard')->with('success',__('Vendor Account Activated Successfully'));
    }

    public function check(Request $request){

        //--- Validation Section
        $input = $request->all();
        $rules = ['shop_name'   => 'unique:users'];
        $customs = ['shop_name.unique' => __('This shop name has already been taken.')];
        $validator = \Validator::make($input, $rules, $customs);
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends
        return response()->json('success');
    }


}