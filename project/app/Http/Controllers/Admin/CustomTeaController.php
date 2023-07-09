<?php

namespace App\Http\Controllers\Admin;

use App\Models\Childcategory;
use App\Models\Subcategory;
use Datatables;
use Carbon\Carbon;
use App\Models\CustomTea;
use App\Models\Currency;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CrossSellingCustomTea;
use Illuminate\Support\Str;

use Validator;
use Image;
use DB;

class CustomTeaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //*** JSON Request
    public function smell_datatables()
    {
         $datas = CustomTea::where('type','=','1')->orderBy('id','desc');

         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('name', function(CustomTea $data) {
                                $name =  mb_strlen($data->name,'UTF-8') > 50 ? mb_substr($data->name,0,50,'UTF-8').'...' : $data->name;
                                return  $name;
                            })
                            ->editColumn('price', function(CustomTea $data) {
                                $sign = Currency::where('is_default','=',1)->first();
                                $price = round($data->price * $sign->value , 2);
                                $price = $sign->sign.$price ;
                                return  $price;
                            })
                            ->editColumn('stock', function(CustomTea $data) {
                                $stck = (string)$data->stock;
                                if($stck == "0")
                                return "Out Of Stock";
                                elseif($stck == null)
                                return "Unlimited";
                                else
                                return $data->stock.' gms';
                            })
                            ->addColumn('status', function(CustomTea $data) {
                                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                                $s = $data->status == 1 ? 'selected' : '';
                                $ns = $data->status == 0 ? 'selected' : '';
                                return '<div class="action-list"><select class="process select droplinks '.$class.'"><option data-val="1" value="'. route('admin-prod-customtea-status',['id1' => $data->id, 'id2' => 1]).'" '.$s.'>Activated</option><<option data-val="0" value="'. route('admin-prod-customtea-status',['id1' => $data->id, 'id2' => 0]).'" '.$ns.'>Deactivated</option>/select></div>';
                            })
                            ->addColumn('action', function(CustomTea $data) {
                                
                                return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button><div class="action-list"><a href="' . route('admin-prod-customtea-edit',$data->id) . '"> <i class="fas fa-edit"></i> Edit</a><a href="javascript:;" data-href="' . route('admin-prod-customtea-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i> Delete</a></div></div>';
                            })
                            ->rawColumns(['name', 'status', 'action'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }
    public function colour_datatables()
    {
         $datas = CustomTea::where('type','=','2')->orderBy('id','desc');

         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('name', function(CustomTea $data) {
                                $name =  mb_strlen($data->name,'UTF-8') > 50 ? mb_substr($data->name,0,50,'UTF-8').'...' : $data->name;
                                return  $name;
                            })
                            ->editColumn('price', function(CustomTea $data) {
                                $sign = Currency::where('is_default','=',1)->first();
                                $price = round($data->price * $sign->value , 2);
                                $price = $sign->sign.$price ;
                                return  $price;
                            })
                            ->editColumn('stock', function(CustomTea $data) {
                                $stck = (string)$data->stock;
                                if($stck == "0")
                                return "Out Of Stock";
                                elseif($stck == null)
                                return "Unlimited";
                                else
                                return $data->stock.' gms';
                            })
                            ->addColumn('status', function(CustomTea $data) {
                                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                                $s = $data->status == 1 ? 'selected' : '';
                                $ns = $data->status == 0 ? 'selected' : '';
                                return '<div class="action-list"><select class="process select droplinks '.$class.'"><option data-val="1" value="'. route('admin-prod-customtea-status',['id1' => $data->id, 'id2' => 1]).'" '.$s.'>Activated</option><<option data-val="0" value="'. route('admin-prod-customtea-status',['id1' => $data->id, 'id2' => 0]).'" '.$ns.'>Deactivated</option>/select></div>';
                            })
                            ->addColumn('action', function(CustomTea $data) {
                                
                                return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button><div class="action-list"><a href="' . route('admin-prod-customtea-edit',$data->id) . '"> <i class="fas fa-edit"></i> Edit</a><a href="javascript:;" data-href="' . route('admin-prod-customtea-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i> Delete</a></div></div>';
                            })
                            ->rawColumns(['name', 'status', 'action'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }

    

    //*** GET Request
    public function smell()
    {
        return view('admin.customtea.smell');
    }
    public function colour()
    {
        return view('admin.customtea.colour');
    }

    //*** GET Request
    public function deactive()
    {
        return view('admin.customtea.deactive');
    }

    

    //*** GET Request
    public function create()
    {
        
        $sign = Currency::where('is_default','=',1)->first();
        $CustomTeas = CustomTea::where('status', 1)->orderBy('name', 'ASC')->get();
        return view('admin.customtea.create',compact('sign','CustomTeas'));
    }

    

    //*** GET Request
    public function status($id1,$id2)
    {
        $data = CustomTea::findOrFail($id1);
        $data->status = $id2;
        $data->update();
    }

    


    //*** POST Request
    public function store(Request $request)
    {

        

        //--- Validation Section
        $rules = [
            'name'      => 'required',
            'type'       => 'required',
            'stock'       => 'required',
            'price'       => 'required',
            
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = new CustomTea;
        $sign = Currency::where('is_default','=',1)->first();
        $input = $request->all();
        $input['status'] = '1';
        
        // Check Seo
        if (empty($request->seo_check))
        {
            $input['meta_tag'] = null;
            $input['meta_description'] = null;
        }
        else {
            if (!empty($request->meta_tag))
            {
                $input['meta_tag'] = implode(',', $request->meta_tag);
            }
        }

        



        // Conert Price According to Currency
        $input['price'] = ($input['price'] / $sign->value);



        // Save Data
        $data->fill($input)->save();

        

        

        //--- Redirect Section
        $msg = 'New Custom Tea Added Successfully.';
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    


    //*** GET Request
    public function edit($id)
    {
        if(!CustomTea::where('id',$id)->exists())
        {
            return redirect()->route('admin.dashboard')->with('unsuccess',__('Sorry the page does not exist.'));
        }
        

        
        $data = CustomTea::findOrFail($id);
        $sign = Currency::where('is_default','=',1)->first();


        
            return view('admin.customtea.edit',compact('data','sign'));
    }

    

    //*** POST Request
    public function update(Request $request, $id)
    {
     
        

        //--- Validation Section
        $rules = [
            'name'      => 'required',
            'type'       => 'required',
            'stock'       => 'required',
            'price'       => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends


        //-- Logic Section
        $data = CustomTea::findOrFail($id);
        $sign = Currency::where('is_default','=',1)->first();
        $input = $request->all();
            // Check Seo
        if (empty($request->seo_check))
         {
            $input['meta_tag'] = null;
            $input['meta_description'] = null;
         }
         else {
        if (!empty($request->meta_tag))
         {
            $input['meta_tag'] = implode(',', $request->meta_tag);
         }
        }
        $input['price'] = $input['price'] / $sign->value;

         $data->update($input);


        //--- Redirect Section
        $msg = 'CustomTea Updated Successfully.View CustomTea Lists.';
        return response()->json($msg);
        //--- Redirect Section Ends
    }


    

    //*** GET Request
    public function destroy($id)
    {

        $data = CustomTea::findOrFail($id);
        


        
        $data->delete();
        //--- Redirect Section
        $msg = 'Custom Tea Product Deleted Successfully.';
        return response()->json($msg);
        //--- Redirect Section Ends

// CustomTea DELETE ENDS
    }

    
}
