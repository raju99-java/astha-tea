<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Generalsetting;
use App\Models\User;
use App\Classes\GeniusMailer;
use App\Models\Notification;
use Session;
use Auth;
use Illuminate\Support\Facades\Config;
use Validator;

class RegisterController extends Controller
{
	public function __construct()
	{ 
    
  //   $gs = Generalsetting::findOrFail(1);
	// Config::set('captcha.sitekey', $gs->capcha_site_key);
	// Config::set('captcha.secret', $gs->capcha_secret_key);
  $this->middleware('guest', ['except' => ['logout', 'userLogout']]);
	}
	public function showRegisterForm()
    {
    //   $this->code_image();
      return view('user.register');
    }

    public function register(Request $request)
    {

    	$gs = Generalsetting::findOrFail(1);

		// if($gs->is_capcha == 1)
        // {
        //     $rules = [
        //         'g-recaptcha-response' => 'required|captcha'
        //     ];
        //     $customs = [
        //         'g-recaptcha-response.required' => "Please verify that you are not a robot.",
        //         'g-recaptcha-response.captcha' => "Captcha error! try again later or contact site admin..",
        //     ];

        //     $validator = Validator::make($request->all(), $rules, $customs);
        //     if ($validator->fails()) {
        //       return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        //     }
        // }


        //--- Validation Section

        $rules = [
				'name'    => 'required',
				'phone'   => 'required|numeric|digits:10|unique:users',
		        'email'   => 'nullable|email',
                ];
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends
			$otp_number = rand(1000, 9999);
			Session::put('name', $request->name);
			Session::put('phone', $request->phone);
			Session::put('email', $request->email);
			Session::put('otp', $otp_number);
			$message = 'Your OTP for Astha Tea is '. $otp_number;
            $templateid = "1507165773738131051";
            $this->send_sms($request->phone,$message,$templateid);
			return response()->json(1); 

	        // $user = new User;
	        // $input = $request->all();        
	        // $input['password'] = bcrypt($request['password']);
	        // $token = md5(time().$request->name.$request->email);
	        // $input['verification_link'] = $token;
	        // $input['affilate_code'] = md5($request->name.$request->email);

	          
			  
			// $user->fill($input)->save();
	        // if($gs->is_verification_email == 1)
	        // {
	        // $to = $request->email;
	        // $subject = 'Verify your email address.';
	        // $msg = "Dear Customer,<br> We noticed that you need to verify your email address. <a href=".url('user/register/verify/'.$token).">Simply click here to verify. </a>";
	        // //Sending Email To Customer
	        // if($gs->is_smtp == 1)
	        // {
	        // $data = [
	        //     'to' => $to,
	        //     'subject' => $subject,
	        //     'body' => $msg,
	        // ];

	        // $mailer = new GeniusMailer();
	        // $mailer->sendCustomMail($data);
	        // }
	        // else
	        // {
	        // $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
	        // mail($to,$subject,$msg,$headers);
	        // }
          	// return response()->json('We need to verify your email address. We have sent an email to '.$to.' to verify your email address. Please click link in that email to continue.');
	        // }
	        // else {

            // $user->email_verified = 'Yes';
            // $user->update();
	        // $notification = new Notification;
	        // $notification->user_id = $user->id;
	        // $notification->save();
            // Auth::guard('web')->login($user); 
          	// return response()->json(1);
	        // }

    }
	public function Otpregister(Request $request)
    {
        //--- Validation Section
        $rules = [
                  'otp'   => 'required|numeric|digits:4',
                ];

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        $name=Session::get('name');
        $phone=Session::get('phone');
        $email=Session::get('email');
        $otp=Session::get('otp');
        // print_r($otp);
        // exit;
        if($otp != $request->otp){
          return response()->json(array('errors' => [ 0 => 'OTP Does Not Match!' ])); 
        }
		$user = new User;
		$input = [];        
		$input['name'] = $name;
		$input['phone'] = $phone;
		$input['email'] = $email;

			
			
		$user->fill($input)->save();
        session()->forget('name');
        session()->forget('phone');
        session()->forget('email');
          session()->forget('otp');
          Auth::guard('web')->login($user);
         
          return response()->json(1);   
          // Login as User
        //   return response()->json(route('user-dashboard'));
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
    public function resend_otp() {
      $mobile=Session::get('phone');
      
      $otp_number = rand(1000, 9999);
      session()->forget('otp');
      Session::put('otp', $otp_number);
      //send otp
      $message = 'Your OTP for Astha Tea is '. $otp_number;
      $templateid = "1507165773738131051";
      $this->send_sms($mobile,$message,$templateid);
      $data[0] = 1;
      return response()->json($data);
      
    }

    public function token($token)
    {
        $gs = Generalsetting::findOrFail(1);

        if($gs->is_verification_email == 1)
	        {    	
        $user = User::where('verification_link','=',$token)->first();
        if(isset($user))
        {
            $user->email_verified = 'Yes';
            $user->update();
	        $notification = new Notification;
	        $notification->user_id = $user->id;
	        $notification->save();
            Auth::guard('web')->login($user); 
            return redirect()->route('user-dashboard')->with('success','Email Verified Successfully');
        }
    		}
    		else {
    		return redirect()->back();	
    		}
    }
}