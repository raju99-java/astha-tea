<?php

namespace App\Http\Controllers\Sales;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use InvalidArgumentException;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;
use App\Models\CustomTeaOrder;
use App\Models\Blog;
use App\Models\User;
use App\Models\Product;
use App\Models\Counter;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sales');
    }

    public function index()
    {
        $id = Auth::guard('sales')->user()->id;
        
        
        $users= User::where('ban','=','0')->where('registered_by',$id)->get();
        $total_sales_day = Order::where('status','=','completed')->where('salesman_id',$id)->whereDay('created_at', date('d'))->sum('pay_amount', '+', 'wallet_price');
        $total_sales_monthly = Order::where('status','=','completed')->where('salesman_id',$id)->whereMonth('created_at', date('m'))->sum('pay_amount', '+', 'wallet_price');
        $total_sales = Order::where('status','=','completed')->where('salesman_id',$id)->sum('pay_amount', '+', 'wallet_price');

        $total_customtea_sales_day = CustomTeaOrder::where('status','=','completed')->where('salesman_id',$id)->whereDay('created_at', date('d'))->sum('pay_amount', '+', 'wallet_price');
        $total_customtea_sales_monthly = CustomTeaOrder::where('status','=','completed')->where('salesman_id',$id)->whereMonth('created_at', date('m'))->sum('pay_amount', '+', 'wallet_price');
        $total_customtea_sales = CustomTeaOrder::where('status','=','completed')->where('salesman_id',$id)->sum('pay_amount', '+', 'wallet_price');
        
        

        

        $activation_notify = "";


        return view('sales.dashboard',compact('users','activation_notify','total_sales_day','total_sales_monthly','total_sales','total_customtea_sales_day','total_customtea_sales_monthly','total_customtea_sales'));
    }

    public function profile()
    {
        $data = Auth::guard('sales')->user();
        return view('sales.profile',compact('data'));
    }

    public function profileupdate(Request $request)
    {
        //--- Validation Section

        $rules =
        [
            'photo' => 'mimes:jpeg,jpg,png,svg',
            'email' => 'unique:admins,email,'.Auth::guard('admin')->user()->id
        ];


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends
        $input = $request->all();
        $data = Auth::guard('admin')->user();
            if ($file = $request->file('photo'))
            {
                $name = time().str_replace(' ', '', $file->getClientOriginalName());
                $file->move('assets/images/admins/',$name);
                if($data->photo != null)
                {
                    if (file_exists(public_path().'/assets/images/admins/'.$data->photo)) {
                        unlink(public_path().'/assets/images/admins/'.$data->photo);
                    }
                }
            $input['photo'] = $name;
            }
        $data->update($input);
        $msg = 'Successfully updated your profile';
        return response()->json($msg);
    }

    public function passwordreset()
    {
        $data = Auth::guard('admin')->user();
        return view('admin.password',compact('data'));
    }

    public function changepass(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        if ($request->cpass){
            if (Hash::check($request->cpass, $admin->password)){
                if ($request->newpass == $request->renewpass){
                    $input['password'] = Hash::make($request->newpass);
                }else{
                    return response()->json(array('errors' => [ 0 => 'Confirm password does not match.' ]));
                }
            }else{
                return response()->json(array('errors' => [ 0 => 'Current password Does not match.' ]));
            }
        }
        $admin->update($input);
        $msg = 'Successfully change your passwprd';
        return response()->json($msg);
    }

    
    public function checkdeliveryorder(Request $request) {
        if ($request->ajax()) {
            $data_msg = [];
            $id = Auth::guard('delivery')->user()->id;
        
        
            $pending = Order::where('status','=','processing')->where('deliver_by',$id)->get();
            
            $custom_tea_pending = CustomTeaOrder::where('status','=','processing')->where('deliver_by',$id)->get();

            if(sizeof($pending)>0){
                $sound='1';
            }elseif(sizeof($custom_tea_pending)>0){
                $sound='1';
            }else{
                $sound='0';
            }
            $data_msg['status'] = $sound;

            
            return response()->json($data_msg);
        }
    }



}
