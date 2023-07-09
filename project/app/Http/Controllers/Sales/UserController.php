<?php

namespace App\Http\Controllers\Sales;
use Auth;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Withdraw;
use App\Models\Currency;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Validator;
use Session;

class UserController extends Controller
{
    public function __construct()
        {
            $this->middleware('auth:sales');
        }

        //*** JSON Request
        public function datatables(Request $request,$status)
        {
            if($status == 'registered') {
                $id = Auth::guard('sales')->user()->id;
                $datas = User::orderBy('id')->where('registered_by',$id);  
            }
          	elseif($status == 'domestic') {
              $datas = User::where('user_type','domestic')->orderBy('id'); 
            }
          	elseif($status == 'commercial') {
              $datas = User::where('user_type','commercial')->orderBy('id'); 
            }
            else{
              $datas = User::orderBy('id');  
            }
             //--- Integrating This Collection Into Datatables
             return Datatables::of($datas)
                                ->addColumn('action', function(User $data) {
                                    
                                    return '<div class="action-list"><a href="' . route('sales-user-show',$data->id) . '" > <i class="fas fa-eye"></i> Details</a>';
                                }) 
                                ->rawColumns(['action'])
                                ->toJson(); //--- Returning Json Data To Client Side
        }

        //*** GET Request
        public function index()
        {
            return view('sales.user.index');
        }
  		public function commercial_user()
        {
            return view('sales.user.commercial_user');
        }
  		public function domestic_user()
        {
            return view('sales.user.domestic_user');
        }
        public function registered()
        {
            return view('sales.user.registered');
        }

        //*** GET Request
        public function create()
        {
            
            $data = User::where('status', 1)->orderBy('name', 'ASC')->get();
            return view('sales.user.create',compact('data'));
        }

        //*** POST Request
        public function store(Request $request)
        {

            

            //--- Validation Section
            $rules = [
                // 'photo'     => 'mimes:jpeg,jpg,png,svg',
                'user_type'      => 'required',
                'name'      => 'required',
                'email'     => 'nullable|email|unique:users',
                'phone'     => 'required|digits:10|unique:users',
                'family_member'     => 'required',
                'currently_using_tea_brand'     => 'required',
                'address'     => 'required',
                'monthly_consuming_tea_weight' => 'required',
                'monthly_tea_cost' => 'required',
                
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
            }
            //--- Validation Section Ends
            
            

            //--- Logic Section
            $otp_number = rand(1000, 9999);
			Session::put('user_type', $request->user_type);
			Session::put('name', $request->name);
			Session::put('email', $request->email);
			Session::put('phone', $request->phone);
			Session::put('family_member', $request->family_member);
			Session::put('currently_using_tea_brand', $request->currently_using_tea_brand);
			Session::put('address', $request->address);
			Session::put('monthly_consuming_tea_weight', $request->monthly_consuming_tea_weight);
			Session::put('monthly_tea_cost', $request->monthly_tea_cost);
			Session::put('otp', $otp_number);
			$message = 'Your OTP for Astha Tea is '. $otp_number;
            $templateid = "1507165773738131051";
			$this->send_sms($request->phone,$message,$templateid);
			
			
            

            

            

            //--- Redirect Section
            $msg = 'Customer Added Successfully.';
            return response()->json(1);
            //--- Redirect Section Ends
        }
        
        public function otpcreateuser(Request $request)
        {

            

            //--- Validation Section
            $rules = [
                'otp'   => 'required|numeric|digits:4',
                
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
            }
            //--- Validation Section Ends
            $user_type=Session::get('user_type');
            $name=Session::get('name');
            $email=Session::get('email');
            $phone=Session::get('phone');
            $family_member=Session::get('family_member');
            $currently_using_tea_brand=Session::get('currently_using_tea_brand');
            $address=Session::get('address');
            $monthly_consuming_tea_weight=Session::get('monthly_consuming_tea_weight');
            $monthly_tea_cost=Session::get('monthly_tea_cost');
            $otp=Session::get('otp');
            // print_r($otp);
            // exit;
            if($otp != $request->otp){
              return response()->json(array('errors' => [ 0 => 'OTP Does Not Match!' ])); 
            }

            //--- Logic Section
            $data = new User;
            $input = $request->all();
            $id = Auth::guard('sales')->user()->id;
            $input['status'] = '1';
            $input['registered_by'] = $id;
            $input['user_type'] = $user_type;
            $input['name'] = $name;
            $input['email'] = $email;
            $input['phone'] = $phone;
            $input['family_member'] = $family_member;
            $input['currently_using_tea_brand'] = $currently_using_tea_brand;
            $input['address'] = $address;
            $input['monthly_consuming_tea_weight'] = $monthly_consuming_tea_weight;
            $input['monthly_tea_cost'] = $monthly_tea_cost;
            $password=$phone;
            $input['password'] = Hash::make($password);
            
            


            // Save Data
            $data->fill($input)->save();
            session()->forget('user_type');
            session()->forget('name');
            session()->forget('phone');
            session()->forget('email');
            session()->forget('family_member');
            session()->forget('currently_using_tea_brand');
            session()->forget('address');
            session()->forget('monthly_consuming_tea_weight');
            session()->forget('monthly_tea_cost');
            session()->forget('otp');

            

            

            //--- Redirect Section
            $msg = 'Customer Added Successfully.';
            return response()->json(1);
            //--- Redirect Section Ends
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


        //*** GET Request
        public function show($id)
        {
            if(!User::where('id',$id)->exists())
            {
                return redirect()->route('sales.dashboard')->with('unsuccess',__('Sorry the page does not exist.'));
            }
            $data = User::findOrFail($id);
            return view('sales.user.show',compact('data'));
        }

        //*** GET Request
        public function ban($id1,$id2)
        {
            $user = User::findOrFail($id1);
            $user->ban = $id2;
            $user->update();

        }

        

        

}