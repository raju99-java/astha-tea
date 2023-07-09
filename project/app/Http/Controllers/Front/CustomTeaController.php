<?php

namespace App\Http\Controllers\Front;

use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\UserCustomTea;
use App\Models\Currency;
use App\Models\Generalsetting;
use App\Models\Order;
use App\Models\PaymentGateway;
use App\Models\CustomTea;
use App\Models\User;
use Illuminate\Support\Str;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Session;
use Validator;

class CustomTeaController extends Controller
{


    public function __construct()
    {
      
        // $this->middleware('guest', ['except' => ['logout', 'userLogout']]);
    }

    public function customtea()
    {
        $smell = CustomTea::where('type','=','1')->orderBy('id','desc')->where('status','1')->get();
        $color = CustomTea::where('type','=','2')->orderBy('id','desc')->where('status','1')->get();
      return view('front.customtea',compact('smell','color'));
    }
    public function customtea_submit(Request $request)
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
          'weight'    => 'required',
          'color'    => 'required',
          'smell'    => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        $data = new UserCustomTea;
        $sign = Currency::where('is_default','=',1)->first();
        
        $input = $request->all();
        //--- Validation Section Ends
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
        // print_r($smell);
        // exit;
        $input['user_id'] = Auth::user()->id;
        
        $input['price'] = ($total / $sign->value);
        $check=UserCustomTea::where('user_id',Auth::user()->id)->first();
        // Save Data
        if(empty($check)){
        $data->fill($input)->save();
        }else{
          $check->update($input);
        }
			
			return response()->json(route('front.customteacheckout')); 

	        

    }
   
    public function totalpricecheck()
    {
         $data=[];
         $data['status']='0';
         $smell = $_GET['smell'];
         $color = $_GET['color'];
         $weight = $_GET['weight'];
         $smellProduct=CustomTea::where('type','=','1')->where('id',$smell)->first();
         $colorProduct=CustomTea::where('type','=','2')->where('id',$color)->first();
         $colorper=$_GET['weight']*($_GET['colorval']/100);
         $smellper=$_GET['weight']*($_GET['smellval']/100);
         $colorprice=$colorper*$colorProduct->price;
         $smellprice=$smellper*$smellProduct->price;
         $total=ceil($colorprice+$smellprice);
         return response()->json($total);
    } 
    public function customteacheckout()
    {
         $data=[];
         $check=UserCustomTea::where('user_id',Auth::user()->id)->first();
         if (!empty($check)) {
          return redirect()->route('front.customtea')->with('success',"You don't choose any custom tea value to checkout.");
      }
         return response()->json($total);
    } 

   

}
