<?php

namespace App\Http\Controllers\Admin;

use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\SalesPerson;
use App\Models\Order;
use App\Models\CustomTeaOrder;
use App\Models\Currency;
use Illuminate\Support\Str;
use Validator;

class SalesPersonController extends Controller
{
    public function __construct()
        {
            $this->middleware('auth:admin');
        }

        //*** JSON Request
        public function datatables()
        {
             $datas = SalesPerson::orderBy('id');
             //--- Integrating This Collection Into Datatables
             return Datatables::of($datas)
                                ->addColumn('action', function(SalesPerson $data) {
                                    $class = $data->ban == 0 ? 'drop-success' : 'drop-danger';
                                    $s = $data->ban == 1 ? 'selected' : '';
                                    $ns = $data->ban == 0 ? 'selected' : '';
                                    $ban = '<select class="process select droplinks '.$class.'">'.
                '<option data-val="0" value="'. route('admin-salesperson-ban',['id1' => $data->id, 'id2' => 1]).'" '.$s.'>Block</option>'.
                '<option data-val="1" value="'. route('admin-salesperson-ban',['id1' => $data->id, 'id2' => 0]).'" '.$ns.'>UnBlock</option></select>';
                                    return '<div class="action-list"><a href="' . route('admin-salesperson-show',$data->id) . '" > <i class="fas fa-eye"></i> Details</a><a data-href="' . route('admin-salesperson-edit',$data->id) . '" class="edit" data-toggle="modal" data-target="#modal1"> <i class="fas fa-edit"></i>Edit</a><a href="javascript:;" class="send" data-email="'. $data->email .'" data-toggle="modal" data-target="#vendorform"><i class="fas fa-envelope"></i> Send</a>'.$ban.'<a href="javascript:;" data-href="' . route('admin-salesperson-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
                                }) 
                                ->rawColumns(['action'])
                                ->toJson(); //--- Returning Json Data To Client Side
        }

        //*** GET Request
        public function index()
        {
            return view('admin.salesperson.index');
        }

        //*** GET Request
        public function commission()
        {  
            return view('admin.generalsetting.sales_person_commission');
        }
        //*** GET Request
        public function create()
        {
            
            $data = SalesPerson::where('status', 1)->orderBy('name', 'ASC')->get();
            return view('admin.salesperson.create',compact('data'));
        }

        //*** POST Request
        public function store(Request $request)
        {

            

            //--- Validation Section
            $rules = [
                'photo'     => 'mimes:jpeg,jpg,png,svg',
                'name'      => 'required',
                'email'     => 'required|email',
                'phone'     => 'required|digits:10',
                'govt_id_proof'     => 'required|mimes:jpeg,jpg,png,svg',
                'address'     => 'required',
                'password' => 'required|min:6',
                
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
            }
            //--- Validation Section Ends

            //--- Logic Section
            $data = new SalesPerson;
            $input = $request->all();
            $input['status'] = '1';
            $input['password'] = Hash::make($input['password']);
            if ($file = $request->file('photo'))
            {
                $name = time().str_replace(' ', '', $file->getClientOriginalName());
                $file->move('assets/images/salesperson',$name);
                
                $input['photo'] = $name;
            }
            if ($file = $request->file('govt_id_proof'))
            {
                $name = time().str_replace(' ', '', $file->getClientOriginalName());
                $file->move('assets/images/salesperson',$name);
                
                $input['govt_id_proof'] = $name;
            }


            // Save Data
            $data->fill($input)->save();

            

            

            //--- Redirect Section
            $msg = 'New Sales Person Added Successfully.';
            return response()->json($msg);
            //--- Redirect Section Ends
        }

        //*** GET Request
        public function show($id)
        {
            if(!SalesPerson::where('id',$id)->exists())
            {
                return redirect()->route('admin.dashboard')->with('unsuccess',__('Sorry the page does not exist.'));
            }
            $data = SalesPerson::findOrFail($id);
            return view('admin.salesperson.show',compact('data'));
        }

        //*** GET Request
        public function ban($id1,$id2)
        {
            $user = SalesPerson::findOrFail($id1);
            $user->ban = $id2;
            $user->update();

        }

        //*** GET Request    
        public function edit($id)
        {
            $data = SalesPerson::findOrFail($id);
            return view('admin.salesperson.edit',compact('data'));
        }

        //*** POST Request
        public function update(Request $request, $id)
        {
            //--- Validation Section
            $rules = [
                'photo'     => 'mimes:jpeg,jpg,png,svg',
                'name'      => 'required',
                'email'     => 'required|email',
                'phone'     => 'required|digits:10',
                'govt_id_proof'     => 'mimes:jpeg,jpg,png,svg',
                'address'     => 'required',
                'password' => 'nullable|min:6',
                
            ];

            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
              return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
            }
            //--- Validation Section Ends

            $user = SalesPerson::findOrFail($id);
            $data = $request->all();
            $data['password'] = Hash::make($data['password']);
            if ($file = $request->file('photo'))
            {
                $name = time().str_replace(' ', '', $file->getClientOriginalName());
                $file->move('assets/images/salesperson',$name);
                if($user->photo != null)
                {
                    if (file_exists(public_path().'/assets/images/salesperson/'.$user->photo)) {
                        unlink(public_path().'/assets/images/salesperson/'.$user->photo);
                    }
                }
                $data['photo'] = $name;
            }
            if ($file = $request->file('govt_id_proof'))
            {
                $name = time().str_replace(' ', '', $file->getClientOriginalName());
                $file->move('assets/images/salesperson',$name);
                if($user->govt_id_proof != null)
                {
                    if (file_exists(public_path().'/assets/images/salesperson/'.$user->govt_id_proof)) {
                        unlink(public_path().'/assets/images/salesperson/'.$user->govt_id_proof);
                    }
                }
                $data['govt_id_proof'] = $name;
            }
            $user->update($data);
            $msg = 'Sales Person Information Updated Successfully.';
            return response()->json($msg);   
        }

        //*** GET Request Delete
        public function destroy($id)
        {
        $user = SalesPerson::findOrFail($id);



            //If Photo Doesn't Exist
            if($user->photo == null){
                $user->delete();
                //--- Redirect Section     
                $msg = 'Data Deleted Successfully.';
                return response()->json($msg);      
                //--- Redirect Section Ends 
            }
            //If Photo Exist
            if (file_exists(public_path().'/assets/images/salesperson/'.$user->photo)) {
                    unlink(public_path().'/assets/images/salesperson/'.$user->photo);
                 }
            $user->delete();
            //--- Redirect Section     
            $msg = 'Data Deleted Successfully.';
            return response()->json($msg);      
            //--- Redirect Section Ends    
        }

        public function total_sold_order()
        {
            $data = [];
            $datas = SalesPerson::orderBy('id')->get();
            return view('admin.salesperson.total_sold_order',compact('datas'));
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
            $data['total_sales_customtea'] ='₹ '. CustomTeaOrder::where('salesman_id',$input['salesperson'])->where('order_type',$input['order_type'])->where('created_at', '>=', $input['from_date'])->where('created_at', '<=', $input['to_date'])->sum('total_price');
            $data['total_sold_customtea'] = CustomTeaOrder::where('salesman_id',$input['salesperson'])->where('order_type',$input['order_type'])->where('created_at', '>=', $input['from_date'])->where('created_at', '<=', $input['to_date'])->count();
            //--- Redirect Section      
            
            $data['total_sales'] ='₹ '. Order::where('salesman_id',$input['salesperson'])->where('order_type',$input['order_type'])->where('created_at', '>=', $input['from_date'])->where('created_at', '<=', $input['to_date'])->sum('pay_amount', '+', 'wallet_price');
            $data['total_sold'] = Order::where('salesman_id',$input['salesperson'])->where('order_type',$input['order_type'])->where('created_at', '>=', $input['from_date'])->where('created_at', '<=', $input['to_date'])->count();
         //--- Redirect Section 
            $data['msg'] = 'Please Check The Result.';
            return response()->json($data);
        }


            

}