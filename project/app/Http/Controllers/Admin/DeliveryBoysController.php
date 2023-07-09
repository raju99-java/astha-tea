<?php

namespace App\Http\Controllers\Admin;

use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\DeliveryBoy;
use App\Models\Currency;
use Illuminate\Support\Str;
use Validator;

class DeliveryBoysController extends Controller
{
    public function __construct()
        {
            $this->middleware('auth:admin');
        }

        //*** JSON Request
        public function datatables()
        {
             $datas = DeliveryBoy::orderBy('id');
             //--- Integrating This Collection Into Datatables
             return Datatables::of($datas)
                                ->addColumn('action', function(DeliveryBoy $data) {
                                    $class = $data->ban == 0 ? 'drop-success' : 'drop-danger';
                                    $s = $data->ban == 1 ? 'selected' : '';
                                    $ns = $data->ban == 0 ? 'selected' : '';
                                    $ban = '<select class="process select droplinks '.$class.'">'.
                '<option data-val="0" value="'. route('admin-deliveryboys-ban',['id1' => $data->id, 'id2' => 1]).'" '.$s.'>Block</option>'.
                '<option data-val="1" value="'. route('admin-deliveryboys-ban',['id1' => $data->id, 'id2' => 0]).'" '.$ns.'>UnBlock</option></select>';
                                    return '<div class="action-list"><a href="' . route('admin-deliveryboys-show',$data->id) . '" > <i class="fas fa-eye"></i> Details</a><a data-href="' . route('admin-deliveryboys-edit',$data->id) . '" class="edit" data-toggle="modal" data-target="#modal1"> <i class="fas fa-edit"></i>Edit</a><a href="javascript:;" class="send" data-email="'. $data->email .'" data-toggle="modal" data-target="#vendorform"><i class="fas fa-envelope"></i> Send</a>'.$ban.'<a href="javascript:;" data-href="' . route('admin-deliveryboys-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
                                }) 
                                ->rawColumns(['action'])
                                ->toJson(); //--- Returning Json Data To Client Side
        }

        //*** GET Request
        public function index()
        {
            return view('admin.deliveryboy.index');
        }

        
        //*** GET Request
        public function commission()
        {  
            return view('admin.generalsetting.delivery_boy_commission');
        }
        //*** GET Request
        public function create()
        {
            
            $data = DeliveryBoy::where('status', 1)->orderBy('name', 'ASC')->get();
            return view('admin.deliveryboy.create',compact('data'));
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
                'vehicle_number'     => 'required',
                'address'     => 'required',
                'password' => 'required|min:6',
                
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
            }
            //--- Validation Section Ends

            //--- Logic Section
            $data = new DeliveryBoy;
            $input = $request->all();
            $input['status'] = '1';
            $input['password'] = Hash::make($input['password']);
            if ($file = $request->file('photo'))
            {
                $name = time().str_replace(' ', '', $file->getClientOriginalName());
                $file->move('assets/images/deliveryboys',$name);
                
                $input['photo'] = $name;
            }
            if ($file = $request->file('govt_id_proof'))
            {
                $name = time().str_replace(' ', '', $file->getClientOriginalName());
                $file->move('assets/images/deliveryboys',$name);
                
                $input['govt_id_proof'] = $name;
            }


            // Save Data
            $data->fill($input)->save();

            

            

            //--- Redirect Section
            $msg = 'New Delivery Boy Added Successfully.';
            return response()->json($msg);
            //--- Redirect Section Ends
        }

        //*** GET Request
        public function show($id)
        {
            if(!DeliveryBoy::where('id',$id)->exists())
            {
                return redirect()->route('admin.dashboard')->with('unsuccess',__('Sorry the page does not exist.'));
            }
            $data = DeliveryBoy::findOrFail($id);
            return view('admin.deliveryboy.show',compact('data'));
        }

        //*** GET Request
        public function ban($id1,$id2)
        {
            $user = DeliveryBoy::findOrFail($id1);
            $user->ban = $id2;
            $user->update();

        }

        //*** GET Request    
        public function edit($id)
        {
            $data = DeliveryBoy::findOrFail($id);
            return view('admin.deliveryboy.edit',compact('data'));
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
                'vehicle_number'     => 'required',
                'address'     => 'required',
                'password' => 'nullable|min:6',
                
            ];

            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
              return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
            }
            //--- Validation Section Ends

            $user = DeliveryBoy::findOrFail($id);
            $data = $request->all();
            $data['password'] = Hash::make($data['password']);
            if ($file = $request->file('photo'))
            {
                $name = time().str_replace(' ', '', $file->getClientOriginalName());
                $file->move('assets/images/deliveryboys',$name);
                if($user->photo != null)
                {
                    if (file_exists(public_path().'/assets/images/deliveryboys/'.$user->photo)) {
                        unlink(public_path().'/assets/images/deliveryboys/'.$user->photo);
                    }
                }
                $data['photo'] = $name;
            }
            if ($file = $request->file('govt_id_proof'))
            {
                $name = time().str_replace(' ', '', $file->getClientOriginalName());
                $file->move('assets/images/deliveryboys',$name);
                if($user->govt_id_proof != null)
                {
                    if (file_exists(public_path().'/assets/images/deliveryboys/'.$user->govt_id_proof)) {
                        unlink(public_path().'/assets/images/deliveryboys/'.$user->govt_id_proof);
                    }
                }
                $data['govt_id_proof'] = $name;
            }
            $user->update($data);
            $msg = 'Delivery Boy Information Updated Successfully.';
            return response()->json($msg);   
        }

        //*** GET Request Delete
        public function destroy($id)
        {
        $user = DeliveryBoy::findOrFail($id);



            //If Photo Doesn't Exist
            if($user->photo == null){
                $user->delete();
                //--- Redirect Section     
                $msg = 'Data Deleted Successfully.';
                return response()->json($msg);      
                //--- Redirect Section Ends 
            }
            //If Photo Exist
            if (file_exists(public_path().'/assets/images/deliveryboys/'.$user->photo)) {
                    unlink(public_path().'/assets/images/deliveryboys/'.$user->photo);
                 }
            $user->delete();
            //--- Redirect Section     
            $msg = 'Data Deleted Successfully.';
            return response()->json($msg);      
            //--- Redirect Section Ends    
        }


            

}