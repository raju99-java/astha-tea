<?php

namespace App\Http\Controllers\Admin;
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
        $this->middleware('auth:admin');
    }

    //*** JSON Request
    public function datatables(Request $request, $status)
    {
        
        if($status == 'pending'){
            $datas = CustomTeaOrder::where('status','=','pending');
        }
        elseif($status == 'processing') {
            $datas = CustomTeaOrder::where('status','=','processing');
        }
        elseif($status == 'delivered') {
            $datas = CustomTeaOrder::where('status','=','delivered');
        }
        elseif($status == 'completed') {
            $datas = CustomTeaOrder::where('status','=','completed');
        }
        elseif($status == 'declined') {
            $datas = CustomTeaOrder::where('status','=','declined');
        }
        else{
          $datas = CustomTeaOrder::orderBy('id','desc');  
        }
        
         
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('created_at', function(CustomTeaOrder $data) {
                                return date('d-M-Y H:i:s a',strtotime($data->created_at));
                            })
                            ->editColumn('order_number', function(CustomTeaOrder $data) {
                                $id = '<a href="'.route('admin-customtea-order-invoice',$data->id).'">'.$data->order_number.'</a>';
                                return $id;
                            })
                            ->editColumn('pay_amount', function (CustomTeaOrder $data) {
                                return $data->currency_sign . round(($data->pay_amount + $data->wallet_price) * $data->currency_value, 2);
                            })
                            ->addColumn('action', function(CustomTeaOrder $data) {
                                $orders = '<a href="javascript:;" data-href="'. route('admin-customtea-order-edit',$data->id) .'" class="delivery" data-toggle="modal" data-target="#modal1"><i class="fas fa-dollar-sign"></i> Delivery Status</a>';
                                return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button><div class="action-list"><a href="' . route('admin-customtea-order-show',$data->id) . '" > <i class="fas fa-eye"></i> Details</a><a href="javascript:;" class="send" data-email="'. $data->customer_email .'" data-toggle="modal" data-target="#vendorform"><i class="fas fa-envelope"></i> Send</a>'.$orders.'<a class="send" target="_blank" href="'. route('admin-customtea-order-thermal-print',$data->id) .'" ><i class="fas fa-print"></i> Thermal Print</a></div></div>';
                            }) 
                            ->filter(function ($instance) use ($request) {
                                if ($request->get('from_date') != '' && $request->get('to_date') != '') {
                                    $from_date = Carbon::parse($request->get('from_date'))->format('Y-m-d');
                                    $to_date = Carbon::parse($request->get('to_date'))->format('Y-m-d');

                                    $instance->where('created_at', '>=', $from_date)->where('created_at', '<=', $to_date);
                                }
                                if (!empty($request->get('search'))) {
                                    $instance->where(function($w) use($request) {
                                        $search = $request->get('search');
                                        $w->orWhere('customer_phone', 'LIKE', "%$search%")
                                        ->orWhere('order_number', 'LIKE', "%$search%")
                                        ->orWhere('totalweight', 'LIKE', "%$search%")
                                        ->orWhere('pay_amount', 'LIKE', "%$search%");
                                    });
                                }
                            })
                            ->rawColumns(['id','action','order_number'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }
    public function index()
    {
        
        return view('admin.customteaorder.index');
    }
    public function local_order_datatables($status)
    {
        $pincodes=Pickup::select('location')->get();
        if(!empty($pincodes)){
            foreach ($pincodes as $key => $value) {    
                      
              $f[] = $value->location;     
            }           
        }
        
          $datas = CustomTeaOrder::orderBy('id','desc')->whereIn('customer_zip', $f);
        
         
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('order_number', function(CustomTeaOrder $data) {
                                $id = '<a href="'.route('admin-customtea-order-invoice',$data->id).'">'.$data->order_number.'</a>';
                                return $id;
                            })
                            ->editColumn('pay_amount', function (CustomTeaOrder $data) {
                                return $data->currency_sign . round(($data->pay_amount + $data->wallet_price) * $data->currency_value, 2);
                            })
                            ->addColumn('action', function(CustomTeaOrder $data) {
                                $orders = '<a href="javascript:;" data-href="'. route('admin-customtea-order-edit',$data->id) .'" class="delivery" data-toggle="modal" data-target="#modal1"><i class="fas fa-dollar-sign"></i> Delivery Status</a>';
                                return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button><div class="action-list"><a href="' . route('admin-customtea-order-show',$data->id) . '" > <i class="fas fa-eye"></i> Details</a><a href="javascript:;" class="send" data-email="'. $data->customer_email .'" data-toggle="modal" data-target="#vendorform"><i class="fas fa-envelope"></i> Send</a>'.$orders.'<a class="send" target="_blank" href="'. route('admin-customtea-order-thermal-print',$data->id) .'" ><i class="fas fa-print"></i> Thermal Print</a></div></div>';
                            }) 
                            ->rawColumns(['id','action','order_number'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }
    public function local_order()
    {
        return view('admin.customteaorder.local_order');
    }
    public function total_sold_order()
    {
        $data = [];
        return view('admin.customteaorder.total_sold_order',compact('data'));
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
        $data['total_sales'] = CustomTeaOrder::where('created_at', '>=', $input['from_date'])->where('created_at', '<=', $input['to_date'])->sum('total_price');
        $data['total_sold'] = CustomTeaOrder::where('created_at', '>=', $input['from_date'])->where('created_at', '<=', $input['to_date'])->count();
         //--- Redirect Section          
         $data['msg'] = 'Please Check The Result.';
         return response()->json($data);
    }
    public function edit($id)
    {
        $data = CustomTeaOrder::find($id);
        $delivery=DeliveryBoy::where('status','1')->where('ban','0')->get();
        return view('admin.customteaorder.delivery',compact('data','delivery'));
    }


    //*** POST Request
    public function update(Request $request, $id)
    {
        //--- Validation Section
        $rules = [
            'deliver_by'      => 'required',
            
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Logic Section
        $data = CustomTeaOrder::findOrFail($id);

        $input = $request->all();
        
        if ($data->status == "completed"){

        // Then Save Without Changing it.
            $input['status'] = "completed";
            $data->update($input);
            //--- Logic Section Ends
    

        //--- Redirect Section          
        $msg = 'Status Updated Successfully.';
        return response()->json($msg);    
        //--- Redirect Section Ends     

    
            }else{
            if ($input['status'] == "processing"){
                if ($data->status == "processing"){

                }else{
                    if($data->payment_status=='Pending'){
                        $delivery=DeliveryBoy::where('id',$input['deliver_by'])->where('status','1')->where('ban','0')->first();
                        
                        if(!empty($delivery)){
                            $delivery->collection_amount=$delivery->collection_amount+ ($data->pay_amount+$data->wallet_price+$data->shipping_cost);
                            $delivery->save();
                        }
                    }
                $gs = Generalsetting::findOrFail(1);
                if(isset($data->customer_email)){
                if($gs->is_smtp == 1)
                {
                    $maildata = [
                        'to' => $data->customer_email,
                        'subject' => 'Your order '.$data->order_number.' is Processing!',
                        'body' => "Hello ".$data->customer_name.","."\n Your order is processing by one of our courier partner.",
                    ];
    
                    $mailer = new GeniusMailer();
                    $mailer->sendCustomMail($maildata);                
                }
                else
                {
                    $to = $data->customer_email;
                    $subject = 'Your order '.$data->order_number.' is Processing!';
                    $msg = "Hello ".$data->customer_name.","."\n Your order is processing by one of our courier partner.";
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $headers .= "From: ".$gs->from_name."<".$gs->from_email.">";
                    mail($to,$subject,$msg,$headers);                
                }
            }
            }
            }
            if ($input['status'] == "completed"){
                $gs = Generalsetting::findOrFail(1);
                $delivery=DeliveryBoy::where('id',$input['deliver_by'])->where('status','1')->where('ban','0')->first();
                
                if(!empty($delivery)){
                    if($data->payment_status=='Pending'){
                    $delivery->collection_amount=$delivery->collection_amount- ($data->pay_amount+$data->wallet_price+$data->shipping_cost);
                    }
                    $delivery->commission=$delivery->commission+(($data->pay_amount+$data->wallet_price+$data->shipping_cost)*($gs->delivery_boy_commission/100));
                    $delivery->save();
                }
                $user = User::find($data->user_id);
                if( $user ){
                    $user->balance = $user->balance + (($data->pay_amount+$data->wallet_price+$data->shipping_cost)*($gs->customer_cashback/100));
                    $user->save();
                }
                // if(!empty($data->salesman_id)){
                //     $salesman=SalesPerson::where('id',$input['salesman_id'])->where('status','1')->where('ban','0')->first();
                //     if( $salesman ){
                //         $salesman->commission = $salesman->commission + (($data->pay_amount+$data->wallet_price+$data->shipping_cost)*($gs->sales_person_commission/100));
                //         $user->save();
                //     }
                // }
                
                if(isset($data->customer_email)){
                if($gs->is_smtp == 1)
                {
                    $maildata = [
                        'to' => $data->customer_email,
                        'subject' => 'Your order '.$data->order_number.' is Confirmed!',
                        'body' => "Hello ".$data->customer_name.","."\n Thank you for shopping with us. We are looking forward to your next visit.",
                    ];
    
                    $mailer = new GeniusMailer();
                    $mailer->sendCustomMail($maildata);                
                }
                else
                {
                   $to = $data->customer_email;
                   $subject = 'Your order '.$data->order_number.' is Confirmed!';
                   $msg = "Hello ".$data->customer_name.","."\n Thank you for shopping with us. We are looking forward to your next visit.";
                   $headers = "MIME-Version: 1.0" . "\r\n";
                   $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                   $headers .= "From: ".$gs->from_name."<".$gs->from_email.">";
                   mail($to,$subject,$msg,$headers);                
                }
            }
            }
            if ($input['status'] == "declined"){
                $delivery=DeliveryBoy::where('id',$input['deliver_by'])->where('status','1')->where('ban','0')->first();
                
                if(!empty($delivery)){
                    $delivery->collection_amount=$delivery->collection_amount- ($data->pay_amount+$data->wallet_price+$data->shipping_cost);
                    $delivery->save();
                }
                // Refund User Wallet If Any
                if($data->user_id != 0){
                    if($data->wallet_price != 0){
                        $user = User::find($data->user_id);
                        if( $user ){
                            $user->balance = $user->balance + $data->wallet_price;
                            $user->save();
                        }
                    }
                }
                $p1=CustomTea::find($data->p1);
                $p2=CustomTea::find($data->p2);
                $p1->stock=$p1->stock+$data->p1_weight;
                $p1->save();
                $p2->stock=$p2->stock+$data->p2_weight;
                $p2->save();
                


                $gs = Generalsetting::findOrFail(1);
                if(isset($data->customer_email)){
                if($gs->is_smtp == 1)
                {
                    $maildata = [
                        'to' => $data->customer_email,
                        'subject' => 'Your order '.$data->order_number.' is Declined!',
                        'body' => "Hello ".$data->customer_name.","."\n We are sorry for the inconvenience caused. We are looking forward to your next visit.",
                    ];
                $mailer = new GeniusMailer();
                $mailer->sendCustomMail($maildata);
                }
                else
                {
                   $to = $data->customer_email;
                   $subject = 'Your order '.$data->order_number.' is Declined!';
                   $msg = "Hello ".$data->customer_name.","."\n We are sorry for the inconvenience caused. We are looking forward to your next visit.";
                   $headers = "MIME-Version: 1.0" . "\r\n";
                   $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                   $headers .= "From: ".$gs->from_name."<".$gs->from_email.">";
                   mail($to,$subject,$msg,$headers);
                }
            }
    
            }

            $data->update($input);

            


        

         //--- Redirect Section          
         $msg = 'Status Updated Successfully.';
         return response()->json($msg);    
         //--- Redirect Section Ends    
    
            }



        //--- Redirect Section          
        $msg = 'Status Updated Successfully.';
        return response()->json($msg);    
        //--- Redirect Section Ends  


    }



    public function pending()
    {
        return view('admin.customteaorder.pending');
    }
    public function processing()
    {
        return view('admin.customteaorder.processing');
    }
    public function delivered()
    {
        return view('admin.customteaorder.delivered');
    }
    public function completed()
    {
        return view('admin.customteaorder.completed');
    }
    public function declined()
    {
        return view('admin.customteaorder.declined');
    }
    public function show($id)
    {
        $order = CustomTeaOrder::findOrFail($id);
        return view('admin.customteaorder.details',compact('order'));
    }
    public function invoice($id)
    {
        $order = CustomTeaOrder::findOrFail($id);
        return view('admin.customteaorder.invoice',compact('order'));
    }
    public function emailsub(Request $request)
    {
        $gs = Generalsetting::findOrFail(1);
        if($gs->is_smtp == 1)
        {
            $data = 0;
            $datas = [
                    'to' => $request->to,
                    'subject' => $request->subject,
                    'body' => $request->message,
            ];

            $mailer = new GeniusMailer();
            $mail = $mailer->sendCustomMail($datas);
            if($mail) {
                $data = 1;
            }
        }
        else
        {
            $data = 0;
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "From: ".$gs->from_name."<".$gs->from_email.">";
            $mail = mail($request->to,$request->subject,$request->message,$headers);
            if($mail) {
                $data = 1;
            }
        }

        return response()->json($data);
    }

    public function printpage($id)
    {
        $order = CustomTeaOrder::findOrFail($id);
        return view('admin.customteaorder.print',compact('order'));
    }

    public function thermalprintpage($id)
    {
        $order = CustomTeaOrder::findOrFail($id);
        return view('admin.customteaorder.thermalprintpage',compact('order'));
    }


    public function status($id,$status)
    {
        $mainorder = CustomTeaOrder::findOrFail($id);

    }


    







}