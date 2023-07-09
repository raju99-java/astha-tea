<?php

namespace App\Http\Controllers\Delivery;
use Auth;
use Carbon\Carbon;
use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\Generalsetting;
use App\Models\Order;
use App\Models\OrderTrack;
use App\Models\User;
use App\Models\VendorOrder;
use App\Models\Product;
use App\Models\Refund;
use App\Models\Pickup;
use App\Models\DeliveryBoy;
use App\Models\SalesPerson;
use Datatables;
use Validator;
use Illuminate\Http\Request;

class OrderController extends Controller
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
            $datas = Order::where('status','=','processing')->where('deliver_by',$id);
        }
        elseif($status == 'delivered') {
            $datas = Order::where('status','=','delivered')->where('deliver_by',$id);
        }
        elseif($status == 'completed') {
            $datas = Order::where('status','=','completed')->where('deliver_by',$id);
        }
        else{
          $datas = Order::orderBy('id','desc')->where('deliver_by',$id);  
        }
         
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('created_at', function(Order $data) {
                                return date('d-M-Y H:i:s a',strtotime($data->created_at));
                            })
                            ->editColumn('order_number', function(Order $data) {
                                $id = '<a href="'.route('admin-order-invoice',$data->id).'">'.$data->order_number.'</a>';
                                return $id;
                            })
                            ->editColumn('pay_amount', function (Order $data) {
                                return $data->currency_sign . round(($data->pay_amount + $data->wallet_price) * $data->currency_value, 2);
                            })
                            ->addColumn('action', function(Order $data) {

                                $orders = '<a href="javascript:;" data-href="'. route('delivery-order-edit',$data->id) .'" class="delivery" data-toggle="modal" data-target="#modal1"><i class="fas fa-dollar-sign"></i> Delivery Status</a>';
                                if($data->status=='processing'){
                                    return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button><div class="action-list"><a href="' . route('delivery-order-show',$data->id) . '" > <i class="fas fa-eye"></i> Details</a>'.$orders.'</div></div>';
                                }else{
                                    return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button><div class="action-list"><a href="' . route('delivery-order-show',$data->id) . '" > <i class="fas fa-eye"></i> Details</a></div></div>';
                                }
                            }) 
                            
                            ->rawColumns(['id','action','order_number'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }
    
    

    public function total_sold_order()
    {
        $data = [];
        return view('admin.order.total_sold_order',compact('data'));
    }
    public function total_sold_order_count(Request $request)
    {
        //--- Validation Section
        $rules = [
            'from_date'      => 'required|date',
            'to_date'       => 'required|date|after_or_equal:from_date',
            
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        $input = $request->all();
        $data=[];
        $data['total_sales'] = Order::where('created_at', '>=', $input['from_date'])->where('created_at', '<=', $input['to_date'])->sum('pay_amount', '+', 'wallet_price');
        $data['total_sold'] = Order::where('created_at', '>=', $input['from_date'])->where('created_at', '<=', $input['to_date'])->count();
         //--- Redirect Section          
         $data['msg'] = 'Please Check The Result.';
         return response()->json($data);
    }

    public function edit($id)
    {
        $data = Order::find($id);
        return view('delivery.order.delivery',compact('data'));
    }


    //*** POST Request
    public function update(Request $request, $id)
    {
        
        //--- Logic Section
        $data = Order::findOrFail($id);

        $input = $request->all();
        $data->update($input);
        



        //--- Redirect Section          
        $msg = 'Status Updated Successfully.';
        return response()->json($msg);    
        //--- Redirect Section Ends  


    }



    public function pending()
    {
      
        return view('delivery.order.pending');
    }
    public function delivered()
    {
        return view('delivery.order.delivered');
    }
    public function completed()
    {
        return view('delivery.order.completed');
    }
    
    public function show($id)
    {
        $order = Order::findOrFail($id);
        $cart = json_decode($order->cart,true);
        return view('delivery.order.details',compact('order','cart'));
    }
    

    

    public function status($id,$status)
    {
        $mainorder = Order::findOrFail($id);

    }









}