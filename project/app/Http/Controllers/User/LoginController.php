<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Generalsetting;
use Auth;
use Illuminate\Support\Facades\Config;
use Session;
use App\Models\User;
use Validator;

class LoginController extends Controller
{
    public function __construct()
    {
      
        $this->middleware('guest', ['except' => ['logout', 'userLogout']]);
    }

    public function showLoginForm()
    {
      $this->code_image();
      return view('user.login');
    }

    public function login(Request $request)
    {
        //--- Validation Section
        $rules = [
                  'phone'   => 'required|numeric|digits:10',
                ];

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends
        $model = User::where('phone', '=', $request->phone)->first();
      // Attempt to log the user in
      if (!empty($model)) {
        // if successful, then redirect to their intended location

          if($model->ban == 1)
          {
            // Auth::guard('web')->logout();
            return response()->json(array('errors' => [ 0 => 'Your Account Has Been Banned.' ]));   
          }
          $otp_number = rand(1000, 9999);
          Session::put('phone', $request->phone);
          Session::put('otp', $otp_number);
          $message = 'Your OTP for Astha Tea is '. $otp_number;
          $templateid = "1507165773738131051";
          $this->send_sms($request->phone,$message,$templateid);

         
          return response()->json(1);   
          // Login as User
          // return response()->json(route('user-dashboard'));
      }

      // if unsuccessful, then redirect back to the login with the form data
          return response()->json(array('errors' => [ 0 => "Please register to continue! <a style='color:#4C9A2A;' href='".Route('user.register')."'>Click here</a> to register" ]));     
    }
    public function Otplogin(Request $request)
    {
        //--- Validation Section
        $rules = [
                  'otp'   => 'required|numeric|digits:4',
                ];

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        $phone=Session::get('phone');
        $otp=Session::get('otp');
        // print_r($otp);
        // exit;
        if($otp != $request->otp){
          return response()->json(array('errors' => [ 0 => 'OTP Does Not Match!' ])); 
        }

        //--- Validation Section Ends
        $model = User::where('phone', '=', $phone)->first();
      // Attempt to log the user in
      if (!empty($model)) {
        // if successful, then redirect to their intended location

        

          if($model->ban == 1)
          {
            // Auth::guard('web')->logout();
            return response()->json(array('errors' => [ 0 => 'Your Account Has Been Banned.' ]));   
          }

          session()->forget('phone');
          session()->forget('otp');
          Auth::guard('web')->login($model);
         
          // return response()->json(1);   
          // Login as User
          return response()->json(route('user-dashboard'));
      }

      // if unsuccessful, then redirect back to the login with the form data
          return response()->json(array('errors' => [ 0 => 'Credentials Doesn\'t Match !' ]));     
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

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('/');
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
    
}
