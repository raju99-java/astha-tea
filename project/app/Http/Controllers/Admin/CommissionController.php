<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Models\Generalsetting;
use Datatables;

class CommissionController extends Controller
{
    public function main_commission()
    {
        $gs = Generalsetting::find(1);
        $curr = Currency::where('is_default','=',1)->first();
        return view('admin.commission.main_commission',compact('gs','curr'));
    }


    public function category_commission()
    {
        return view('admin.commission.category_commission');
    }


    public function category_commission_datatables()
    {

           $datas = Category::orderBy('id','asc')->where('status',1);
           //--- Integrating This Collection Into Datatables
           return DataTables::of($datas)
                              ->addColumn('action', function(Category $data) {
                                  return '<div class="action-list"><a data-href="' . route('admin-category-commission-create',$data->id) . '" class="edit" data-toggle="modal" data-target="#modal1"> <i class="fas fa-edit"></i>Set Commission</a></div>';
                              }) 

                              ->editColumn('name', function(Category $data) {
                                    return $data->name;
                                })
                              ->editColumn('commission', function(Category $data) {
                                    $commission =   $data->commission == 0 ?$data->commission.'':$data->commission.'%';
                                    return $commission;
                                })
  
                              ->rawColumns(['action','name','commission'])
                              ->toJson();//--- Returning Json Data To Client Side
      }


      public function category_commission_create($id)
      {
          $category = Category::findOrFail($id);
          return view('admin.commission.commission_create',compact('category'));
      }

      public function category_commission_store(Request $request,$id)
      {
          $category = Category::findOrFail($id);
          $category->commission = $request->commission;
          $category->update();
          $mgs  = __('Data Update Successfully');
          return response()->json($mgs);
      }

    
}
