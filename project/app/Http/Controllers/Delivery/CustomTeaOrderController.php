<?php

namespace App\Http\Controllers\Delivery;
use Auth;
use Carbon\Carbon;
use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\Generalsetting;
use App\Models\CustomTeaOrder;
use App\Models\OrderTrack;
use App\Models\User;
use App\Models\VendorOrder;
use App\Models\CustomTea;
use App\Models\Refund;
use App\Models\Pickup;
use App\Models\DeliveryBoy;
use App\Models\SalesPerson;
use Datatables;
use Validator;
use Illuminate\Http\Request;

class CustomTeaOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:delivery');
    }

    //*** JSON Request
    public function datatables(Request $request,$status)
    {
        $id = Auth::guard('delivery')->user()->id;
        if($status == 'pending'){
            $datas = CustomTeaOrder::where('status','=','processing')->where('deliver_by',$id);
        }
        elseif($status == 'delivered') {
            $datas = CustomTeaOrder::where('status','=','delivered')->where('deliver_by',$id);
        }
        elseif($status == 'completed') {
            $datas = CustomTeaOrder::where('status','=','completed')->where('deliver_by',$id);
        }
        else{
          $datas = CustomTeaOrder::orderBy('id','desc')->where('deliver_by',$id);  
        }
         
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('created_at', function(CustomTeaOrder $data) {
                                return date('d-M-Y H:i:s a',strtotime($data->created_at));
                            })
                            ->editColumn('order_number', function(CustomTeaOrder $data) {
                                $id = '<a href="'.route('admin-order-invoice',$data->id).'">'.$data->order_number.'</a>';
                                return $id;
                            })
                            ->editColumn('pay_amount', function (CustomTeaOrder $data) {
                                return $data->currency_sign . round(($data->pay_amount + $data->wallet_price) * $data->currency_value, 2);
                            })
                            ->addColumn('action', function(CustomTeaOrder $data) {

                                $orders = '<a href="javascript:;" data-href="'. route('delivery-customtea-order-edit',$data->id) .'" class="delivery" data-toggle="modal" data-target="#modal1"><i class="fas fa-dollar-sign"></i> Delivery Status</a>';
                                if($data->status=='processing'){
                                    return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button><div class="action-list"><a href="' . route('delivery-customtea-order-show',$data->id) . '" > <i class="fas fa-eye"></i> Details</a>'.$orders.'</div></div>';
                                }else{
                                    return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button><div class="action-list"><a href="' . route('delivery-customtea-order-show',$data->id) . '" > <i class="fas fa-eye"></i> Details</a></div></div>';
                                }
                            }) 
                            
                            ->rawColumns(['id','action','order_number'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }
    
    
    public function edit($id)
    {
        $data = CustomTeaOrder::find($id);
        return view('delivery.customteaorder.delivery',compact('data'));
    }


    //*** POST Request
    public function update(Request $request, $id)
    {
        //--- Logic Section
        $data = CustomTeaOrder::findOrFail($id);

        $input = $request->all();
        $data->update($input);



        //--- Redirect Section          
        $msg = 'Status Updated Successfully.';
        return response()->json($msg);    
        //--- Redirect Section Ends  


    }



    public function pending()
    {
        return view('delivery.customteaorder.pending');
    }
    public function delivered()
    {
        return view('delivery.customteaorder.delivered');
    }
    public function completed()
    {
        return view('delivery.customteaorder.completed');
    }
    public function declined()
    {
        return view('delivery.customteaorder.declined');
    }
    public function show($id)
    {
        $order = CustomTeaOrder::findOrFail($id);
        return view('delivery.customteaorder.details',compact('order'));
    }
    


    public function status($id,$status)
    {
        $mainorder = CustomTeaOrder::findOrFail($id);

    }


    







}