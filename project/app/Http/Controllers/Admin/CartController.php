<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Country;
use App\Models\Product;
use App\Models\Currency;
use App\Models\Coupon;
use App\Models\Generalsetting;
use App\Models\State;
use Illuminate\Support\Facades\Auth;
use Session;

class CartController extends Controller
{

    public function cart()
    {
       
        if (!Session::has('admin_cart')) {
            return view('front.cart');
        }
        if (Session::has('already')) {
            Session::forget('already');
        }
        if (Session::has('coupon')) {
            Session::forget('coupon');
        }
        if (Session::has('coupon_total')) {
            Session::forget('coupon_total');
        }
        if (Session::has('coupon_total1')) {
            Session::forget('coupon_total1');
        }
        if (Session::has('coupon_percentage')) {
            Session::forget('coupon_percentage');
        }
        $gs = Generalsetting::findOrFail(1);
        $oldCart = Session::get('admin_cart');
        $cart = new Cart($oldCart);
        $products = $cart->items;
        $totalPrice = $cart->totalPrice;
        $mainTotal = $totalPrice;
        $tx = $gs->tax;
        if($tx != 0)
        {
            $tax = ($totalPrice / 100) * $tx;
            $mainTotal = $totalPrice + $tax;
        }
       
        return view('front.cart', compact('products','totalPrice','mainTotal','tx')); 
    }

    public function admincartload ()
    {
        if (Session::has('currency')) 
        {
          $curr = Currency::find(Session::get('currency'));
        }
        else
        {
            $curr = Currency::where('is_default','=',1)->first();
        }
        return view('load.admin_cart',compact('curr')); 
    }



    public function walletcheck()
    {

        if (Session::has('currency')) 
        {
          $curr = Currency::find(Session::get('currency'));
        }
        else
        {
            $curr = Currency::where('is_default','=',1)->first();
        }

        $amount = (double)$_GET['code'];
        $total = (double)$_GET['total'];
        $prev_price = (double)$_GET['prev_price'];
        $balance = Auth::user()->balance * $curr->value;
        $total_price = $amount + $prev_price;
        if($total_price <= $balance){
            if($amount > 0 && $amount <= $total){
                $total -= $amount;
                $data[0] = $total;
                $data[1]  = $amount;
                return response()->json($data);
            }else {
                return response()->json(0);
            }
        }else{
            return response()->json(1);
        }

    }
    

   public function addtocart($id)
    {
       
        $prod = Product::where('id','=',$id)->first(['id','user_id','slug','name','photo','size','size_qty','size_price','color','price','stock','type','file','link','license','license_qty','measure','whole_sell_qty','whole_sell_discount','attributes']);

        // Set Attrubutes

        if (Session::has('language')) 
        {
            $data = \DB::table('languages')->find(Session::get('language'));
            $data_results = file_get_contents(public_path().'/assets/languages/'.$data->file);
            $lang = json_decode($data_results);
        }
        else
        {
            $data = \DB::table('languages')->where('is_default','=',1)->first();
            $data_results = file_get_contents(public_path().'/assets/languages/'.$data->file);
            $lang = json_decode($data_results);
        }  

        $keys = '';
        $values = '';
        if(!empty($prod->license_qty))
        {
        $lcheck = 1;
            foreach($prod->license_qty as $ttl => $dtl)
            {
                if($dtl < 1)
                {
                    $lcheck = 0;
                }
                else
                {
                    $lcheck = 1;
                    break;
                }                    
            }
                if($lcheck == 0)
                {
                    return redirect()->route('front.cart')->with('unsuccess',$lang->out_stock);              
                }
        }

        // Set Size

        $size = '';
        if(!empty($prod->size))
        { 
        $size = trim($prod->size[0]);
        }  
        $size = str_replace(' ','-',$size);

        // Set Color

        $color = '';
        if(!empty($prod->color))
        { 
        $color = $prod->color[0];
        $color = str_replace('#','',$color);
        }  

        if($prod->user_id != 0){
        $gs = Generalsetting::findOrFail(1);
        if($prod->category->commission != 0){
            $prc = $prod->price + $prod->price * $prod->category->commission / 100 ;
        }else{
            $prc = $prod->price + $gs->fixed_commission + ($prod->price/100) * $gs->percentage_commission ;
        }
        
        $prod->price = round($prc,2);
        }

        // Set Attribute

            if (!empty($prod->attributes))
            {
                $attrArr = json_decode($prod->attributes, true);

                $count = count($attrArr);
                $i = 0;
                $j = 0; 
                      if (!empty($attrArr))
                      {
                          foreach ($attrArr as $attrKey => $attrVal)
                          {

                            if (is_array($attrVal) && array_key_exists("details_status",$attrVal) && $attrVal['details_status'] == 1) {
                                if($j == $count - 1){
                                    $keys .= $attrKey;
                                }else{
                                    $keys .= $attrKey.',';
                                }
                                $j++;

                                foreach($attrVal['values'] as $optionKey => $optionVal)
                                {
                                    
                                    $values .= $optionVal . ',';

                                    $prod->price += $attrVal['prices'][$optionKey];
                                    break;
                                    
                                }
                            }
                          }
                      }
                }
                $keys = rtrim($keys, ',');
                $values = rtrim($values, ',');


        $oldCart = Session::has('admin_cart') ? Session::get('admin_cart') : null;
        $cart = new Cart($oldCart);

        $cart->add($prod, $prod->id, $size ,$color, $keys, $values);
        if($cart->items[$id.$size.$color.str_replace(str_split(' ,'),'',$values)]['dp'] == 1)
        {
            return redirect()->route('front.cart')->with('unsuccess',$lang->already_cart);
        }
        if($cart->items[$id.$size.$color.str_replace(str_split(' ,'),'',$values)]['stock'] < 0)
        {
            return redirect()->route('front.cart')->with('unsuccess',$lang->out_stock);
        }
        
        if($cart->items[$id.$size.$color.str_replace(str_split(' ,'),'',$values)]['size_qty'])
        {
            if($cart->items[$id.$size.$color.str_replace(str_split(' ,'),'',$values)]['qty'] > $cart->items[$id.$size.$color.str_replace(str_split(' ,'),'',$values)]['size_qty'])
            {
                return redirect()->route('front.cart')->with('unsuccess',$lang->out_stock);
            }           
        }

        $cart->totalPrice = 0;
        foreach($cart->items as $data)
        $cart->totalPrice += $data['price'];
        Session::put('admin_cart',$cart);
         return redirect()->route('front.cart');
    }  

   public function addcart(Request $request ,$id)
    {
        
        $prod = Product::where('id','=',$id)->first(['id','user_id','slug','name','photo','size','size_qty','size_price','color','price','stock','type','file','link','license','license_qty','measure','whole_sell_qty','whole_sell_discount','attributes','min_qty']);


        // Set Attrubutes

        $keys = '';
        $values = '';
        if(!empty($prod->license_qty))
        {
        $lcheck = 1;
            foreach($prod->license_qty as $ttl => $dtl)
            {
                if($dtl < 1)
                {
                    $lcheck = 0;
                }
                else
                {
                    $lcheck = 1;
                    break;
                }                    
            }
                if($lcheck == 0)
                {
                    return 0;        
                }
        }

        // Set Size
        if(isset($request->size) && $request->size != 'undefined'){
            $size = trim($request->size);
        }else{
            $size = '';
            if(!empty($prod->size))
            { 
            $size = trim($prod->size[0]);
            }  
            $size = str_replace(' ','-',$size);
        }
       
        // Set Color
        if(isset($request->color) && $request->color != 'undefined'){
            $color = $request->color;
        }else{
            $color = '';
            if(!empty($prod->color))
            { 
            $color = $prod->color[0];
            $color = str_replace('#','',$color);
            }  
        }
       
    
        // Vendor Comission

        if($prod->user_id != 0){
        $gs = Generalsetting::findOrFail(1);
        if($prod->category->commission != 0){
            $prc = $prod->price + $prod->price * $prod->category->commission / 100 ;
        }else{
            $prc = $prod->price + $gs->fixed_commission + ($prod->price/100) * $gs->percentage_commission ;
        }
        $prod->price = round($prc,2);
        }

        // Set Attribute

            if (!empty($prod->attributes))
            {
                $attrArr = json_decode($prod->attributes, true);

                $count = count($attrArr);
                $i = 0;
                $j = 0; 
                      if (!empty($attrArr))
                      {
                          foreach ($attrArr as $attrKey => $attrVal)
                          {

                            if (is_array($attrVal) && array_key_exists("details_status",$attrVal) && $attrVal['details_status'] == 1) {
                                if($j == $count - 1){
                                    $keys .= $attrKey;
                                }else{
                                    $keys .= $attrKey.',';
                                }
                                $j++;

                                foreach($attrVal['values'] as $optionKey => $optionVal)
                                {
                                    
                                    $values .= $optionVal . ',';

                                    $prod->price += $attrVal['prices'][$optionKey];
                                    break;
                                     
                                    
                                }

                            }
                          }

                      }

                }
                $keys = rtrim($keys, ',');
                $values = rtrim($values, ',');


        $oldCart = Session::has('admin_cart') ? Session::get('admin_cart') : null;
        $cart = new Cart($oldCart);

        $cart->add($prod, $prod->id,$size,$color,$keys,$values);
        if($cart->items[$id.$size.$color.str_replace(str_split(' ,'),'',$values)]['dp'] == 1)
        {
            return 'digital';
        }
        if($cart->items[$id.$size.$color.str_replace(str_split(' ,'),'',$values)]['stock'] < 0)
        {
            return 0;
        }

        if($cart->items[$id.$size.$color.str_replace(str_split(' ,'),'',$values)]['size_qty'])
        {
            if($cart->items[$id.$size.$color.str_replace(str_split(' ,'),'',$values)]['qty'] > $cart->items[$id.$size.$color.str_replace(str_split(' ,'),'',$values)]['size_qty'])
            {
                return 0;
            }           
        }
        $cart->totalPrice = 0;
        foreach($cart->items as $data)
        $cart->totalPrice += $data['price'];
        Session::put('admin_cart',$cart);
        $data[0] = count($cart->items);        
        return response()->json($data);           
    }  

    public function addnumcart()
    {
       
        $id = $_GET['id'];
        $qty = $_GET['qty'];
        $size = str_replace(' ','-',$_GET['size']);
        $color = $_GET['color'];
        $size_qty = $_GET['size_qty'];
        $size_price = (double)$_GET['size_price'];
        $size_key = $_GET['size_key'];
        $keys =  $_GET['keys'];
        $values = $_GET['values'];
        $prices = $_GET['prices'];
        $keys = $keys == "" ? '' :implode(',',$keys);
        $values = $values == "" ? '' : implode(',',$values );
        if (Session::has('currency')) {
            $curr = Currency::find(Session::get('currency'));
        }
        else {
            $curr = Currency::where('is_default','=',1)->first();
        }

        $size_price = ($size_price / $curr->value);
        $prod = Product::where('id','=',$id)->first(['id','user_id','slug','name','photo','size','size_qty','size_price','color','price','stock','type','file','link','license','license_qty','measure','whole_sell_qty','whole_sell_discount','attributes']);


        if($prod->user_id != 0){
        $gs = Generalsetting::findOrFail(1);
        if($prod->category->commission != 0){
            $prc = $prod->price + $prod->price * $prod->category->commission / 100 ;
        }else{
            $prc = $prod->price + $gs->fixed_commission + ($prod->price/100) * $gs->percentage_commission ;
        }
        $prod->price = round($prc,2);
        }
        if(!empty($prices))
        {
         foreach($prices as $data){
            $prod->price += ($data / $curr->value);
        }
            
        }

        if(!empty($prod->license_qty))
        {
        $lcheck = 1;
            foreach($prod->license_qty as $ttl => $dtl)
            {
                if($dtl < 1)
                {
                    $lcheck = 0;
                }
                else
                {
                    $lcheck = 1;
                    break;
                }                    
            }
                if($lcheck == 0)
                {
                    return 0;            
                }
        }
        if(empty($size))
        {
            if(!empty($prod->size))
            { 
            $size = trim($prod->size[0]);
            }   
            $size = str_replace(' ','-',$size);       
        }
 
        if(empty($color))
        {
            if(!empty($prod->color))
            { 
            $color = $prod->color[0];
                    
            }          
        }
        $color = str_replace('#','',$color);
        $oldCart = Session::has('admin_cart') ? Session::get('admin_cart') : null;
        $cart = new Cart($oldCart);
        $cart->addnum($prod, $prod->id, $qty, $size,$color,$size_qty,$size_price,$size_key,$keys,$values);
        if($cart->items[$id.$size.$color.str_replace(str_split(' ,'),'',$values)]['dp'] == 1)
        {
            return 'digital';
        }
        if($cart->items[$id.$size.$color.str_replace(str_split(' ,'),'',$values)]['stock'] < 0)
        {
            return 0;
        }

        if($cart->items[$id.$size.$color.str_replace(str_split(' ,'),'',$values)]['size_qty'])
        {
            if($cart->items[$id.$size.$color.str_replace(str_split(' ,'),'',$values)]['qty'] > $cart->items[$id.$size.$color.str_replace(str_split(' ,'),'',$values)]['size_qty'])
            {
                return 0;
            }           
        }

        $cart->totalPrice = 0;
        foreach($cart->items as $data)
        $cart->totalPrice += $data['price'];        
        Session::put('admin_cart',$cart);
        $data[0] = count($cart->items);   
        return response()->json($data);        
    }  

    public function addtonumcart()
    {
        
        $id = $_GET['id'];
        $qty = $_GET['qty'];
        $size = str_replace(' ','-',$_GET['size']);
        $color = $_GET['color'];
        $size_qty = $_GET['size_qty'];
        $size_price = (double)$_GET['size_price'];
        $size_key = $_GET['size_key'];
        $keys =  $_GET['keys'];
        $keys = explode(",",$keys);
        $values = $_GET['values'];
        $values = explode(",",$values);
        $prices = $_GET['prices'];
        $prices = explode(",",$prices);
        $keys = $keys == "" ? '' :implode(',',$keys);

        $values = $values == "" ? '' : implode(',',$values );
        if (Session::has('currency')) {
            $curr = Currency::find(Session::get('currency'));
        }
        else {
            $curr = Currency::where('is_default','=',1)->first();
        }

        $size_price = ($size_price / $curr->value);
        $prod = Product::where('id','=',$id)->first(['id','user_id','slug','name','photo','size','size_qty','size_price','color','price','stock','type','file','link','license','license_qty','measure','whole_sell_qty','whole_sell_discount','attributes']);

        if (Session::has('language')) 
        {
            $data = \DB::table('languages')->find(Session::get('language'));
            $data_results = file_get_contents(public_path().'/assets/languages/'.$data->file);
            $lang = json_decode($data_results);

        }
        else
        {
            $data = \DB::table('languages')->where('is_default','=',1)->first();
            $data_results = file_get_contents(public_path().'/assets/languages/'.$data->file);
            $lang = json_decode($data_results);

        }  

        if($prod->user_id != 0){
        $gs = Generalsetting::findOrFail(1);
        if($prod->category->commission != 0){
            $prc = $prod->price + $prod->price * $prod->category->commission / 100 ;
        }else{
            $prc = $prod->price + $gs->fixed_commission + ($prod->price/100) * $gs->percentage_commission ;
        }
        $prod->price = round($prc,2);
        }
        if(!empty($prices)){
            if(!empty($prices[0])){
                foreach($prices as $data){
                    $prod->price += ($data / $curr->value);
                }
            }
        }

        if(!empty($prod->license_qty))
        {
        $lcheck = 1;
            foreach($prod->license_qty as $ttl => $dtl)
            {
                if($dtl < 1)
                {
                    $lcheck = 0;
                }
                else
                {
                    $lcheck = 1;
                    break;
                }                    
            }
                if($lcheck == 0)
                {
                    return redirect()->route('front.cart')->with('unsuccess',$lang->out_stock);           
                }
        }
        if(empty($size))
        {
            if(!empty($prod->size))
            { 
            $size = trim($prod->size[0]);
            }          
            $size = str_replace(' ','-',$size);
        }
 
        if(empty($color))
        {
            if(!empty($prod->color))
            { 
            $color = $prod->color[0];
                    
            }          
        }
        $color = str_replace('#','',$color);
        $oldCart = Session::has('admin_cart') ? Session::get('admin_cart') : null;
        $cart = new Cart($oldCart);
        $cart->addnum($prod, $prod->id, $qty, $size,$color,$size_qty,$size_price,$size_key,$keys,$values);
        if($cart->items[$id.$size.$color.str_replace(str_split(' ,'),'',$values)]['dp'] == 1)
        {
            return redirect()->route('front.cart')->with('unsuccess',$lang->already_cart);  
        }
        if($cart->items[$id.$size.$color.str_replace(str_split(' ,'),'',$values)]['stock'] < 0)
        {
            return redirect()->route('front.cart')->with('unsuccess',$lang->out_stock); 
        }

        if($cart->items[$id.$size.$color.str_replace(str_split(' ,'),'',$values)]['size_qty'])
        {
            if($cart->items[$id.$size.$color.str_replace(str_split(' ,'),'',$values)]['qty'] > $cart->items[$id.$size.$color.str_replace(str_split(' ,'),'',$values)]['size_qty'])
            {
                return redirect()->route('front.cart')->with('unsuccess',$lang->out_stock); 
            }           
        }

        $cart->totalPrice = 0;
        foreach($cart->items as $data)
        $cart->totalPrice += $data['price'];        
        Session::put('admin_cart',$cart);
        return redirect()->route('front.cart');      
    }  

    public function addbyone()
    {
       
        if (Session::has('coupon')) {
            Session::forget('coupon');
        }
        $gs = Generalsetting::findOrFail(1);
        if (Session::has('currency')) 
        {
            $curr = Currency::find(Session::get('currency'));
        }
        else
        {
            $curr = Currency::where('is_default','=',1)->first();
        }
        $id = $_GET['id'];
        $itemid = $_GET['itemid'];
        $size_qty = $_GET['size_qty'];
        $size_price = $_GET['size_price'];
        $prod = Product::where('id','=',$id)->first(['id','user_id','slug','name','photo','size','size_qty','size_price','color','price','stock','type','file','link','license','license_qty','measure','whole_sell_qty','whole_sell_discount','attributes']);

        if($prod->user_id != 0){
        $gs = Generalsetting::findOrFail(1);
        if($prod->category->commission != 0){
            $prc = $prod->price + $prod->price * $prod->category->commission / 100 ;
        }else{
            $prc = $prod->price + $gs->fixed_commission + ($prod->price/100) * $gs->percentage_commission ;
        }
        $prod->price = round($prc,2);
        }

            if (!empty($prod->attributes))
            {
                $attrArr = json_decode($prod->attributes, true);
                $count = count($attrArr);
                $j = 0; 
                      if (!empty($attrArr))
                      {
                          foreach ($attrArr as $attrKey => $attrVal)
                          {

                            if (is_array($attrVal) && array_key_exists("details_status",$attrVal) && $attrVal['details_status'] == 1) {

                                foreach($attrVal['values'] as $optionKey => $optionVal)
                                {
                                    $prod->price += $attrVal['prices'][$optionKey];
                                    break;
                                }
                            }
                          }

                      }
                }

        if(!empty($prod->license_qty))
        {
        $lcheck = 1;
            foreach($prod->license_qty as $ttl => $dtl)
            {
                if($dtl < 1)
                {
                    $lcheck = 0;
                }
                else
                {
                    $lcheck = 1;
                    break;
                }                    
            }
                if($lcheck == 0)
                {
                    return 0;            
                }
        }
        $oldCart = Session::has('admin_cart') ? Session::get('admin_cart') : null;
        $cart = new Cart($oldCart);
        $cart->adding($prod, $itemid,$size_qty,$size_price);
        if($cart->items[$itemid]['stock'] < 0)
        {
            return 0;
        }
        if(!empty($size_qty))
        {
            if($cart->items[$itemid]['qty'] > $cart->items[$itemid]['size_qty'])
            {
                return 0;
            }            
        }
        $cart->totalPrice = 0;
        foreach($cart->items as $data)
        $cart->totalPrice += $data['price'];        
        Session::put('admin_cart',$cart);
        $data[0] = $cart->totalPrice;

        $data[3] = $data[0];
        $tx = $gs->tax;
        if($tx != 0)
        {
            $tax = ($data[0] / 100) * $tx;
            $data[3] = $data[0] + $tax;
        }  

        $data[1] = $cart->items[$itemid]['qty']; 
        $data[2] = $cart->items[$itemid]['price'];
        $data[4] = $cart->items[$itemid]['item_price'];
        $data[0] = round($data[0] * $curr->value,2);
        $data[2] = round($data[2] * $curr->value,2);
        $data[3] = round($data[3] * $curr->value,2);
        $data[4] = round($data[4] * $curr->value,2);
        if($gs->currency_format == 0){
            $data[0] = $curr->sign.$data[0];
            $data[2] = $curr->sign.$data[2];
            $data[3] = $curr->sign.$data[3];
            $data[4] = $curr->sign.$data[4];
        }
        else{
            $data[0] = $data[0].$curr->sign;
            $data[2] = $data[2].$curr->sign;
            $data[3] = $data[3].$curr->sign;
            $data[4] = $data[4].$curr->sign;
        }     
        return response()->json($data);          
    }  

    public function reducebyone()
    {
        
        if (Session::has('coupon')) {
            Session::forget('coupon');
        }
        $gs = Generalsetting::findOrFail(1);
        if (Session::has('currency')) 
        {
            $curr = Currency::find(Session::get('currency'));
        }
        else
        {
            $curr = Currency::where('is_default','=',1)->first();
        }
        $id = $_GET['id'];
        $itemid = $_GET['itemid'];
        $size_qty = $_GET['size_qty'];
        $size_price = $_GET['size_price'];
        $prod = Product::where('id','=',$id)->first(['id','user_id','slug','name','photo','size','size_qty','size_price','color','price','stock','type','file','link','license','license_qty','measure','whole_sell_qty','whole_sell_discount','attributes']);
        if($prod->user_id != 0){
        $gs = Generalsetting::findOrFail(1);
        if($prod->category->commission != 0){
            $prc = $prod->price + $prod->price * $prod->category->commission / 100 ;
        }else{
            $prc = $prod->price + $gs->fixed_commission + ($prod->price/100) * $gs->percentage_commission ;
        }
        $prod->price = round($prc,2);
        }

            if (!empty($prod->attributes))
            {
                $attrArr = json_decode($prod->attributes, true);
                $count = count($attrArr);
                $j = 0; 
                      if (!empty($attrArr))
                      {
                          foreach ($attrArr as $attrKey => $attrVal)
                          {
                            if (is_array($attrVal) && array_key_exists("details_status",$attrVal) && $attrVal['details_status'] == 1) {

                                foreach($attrVal['values'] as $optionKey => $optionVal)
                                {
                                    $prod->price += $attrVal['prices'][$optionKey];
                                    break;
                                }

                            }
                          }

                      }
                }

        if(!empty($prod->license_qty))
        {
        $lcheck = 1;
            foreach($prod->license_qty as $ttl => $dtl)
            {
                if($dtl < 1)
                {
                    $lcheck = 0;
                }
                else
                {
                    $lcheck = 1;
                    break;
                }                    
            }
            if($lcheck == 0)
            {
                return 0;            
            }
        }
        $oldCart = Session::has('admin_cart') ? Session::get('admin_cart') : null;
        $cart = new Cart($oldCart);
        $cart->reducing($prod, $itemid,$size_qty,$size_price);
        $cart->totalPrice = 0;
        foreach($cart->items as $data)
        $cart->totalPrice += $data['price'];    
        
        Session::put('admin_cart',$cart);
        $data[0] = $cart->totalPrice;

        $data[3] = $data[0];
        $tx = $gs->tax;
        if($tx != 0)
        {
            $tax = ($data[0] / 100) * $tx;
            $data[3] = $data[0] + $tax;
        }  

        $data[1] = $cart->items[$itemid]['qty']; 
        $data[2] = $cart->items[$itemid]['price'];
        $data[4] = $cart->items[$itemid]['item_price'];
        $data[0] = round($data[0] * $curr->value,2);
        $data[2] = round($data[2] * $curr->value,2);
        $data[3] = round($data[3] * $curr->value,2);
        $data[4] = round($data[4] * $curr->value,2);
        if($gs->currency_format == 0){
            $data[0] = $curr->sign.$data[0];
            $data[2] = $curr->sign.$data[2];
            $data[3] = $curr->sign.$data[3];
            $data[4] = $curr->sign.$data[4];
        }
        else{
            $data[0] = $data[0].$curr->sign;
            $data[2] = $data[2].$curr->sign;
            $data[3] = $data[3].$curr->sign;
            $data[4] = $data[4].$curr->sign;
        }       
        return response()->json($data);        
    }  

    public function upcolor()
    {
         $id = $_GET['id'];
         $color = $_GET['color'];
        $prod = Product::where('id','=',$id)->first(['id','user_id','slug','name','photo','size','size_qty','size_price','color','price','stock','type','file','link','license','license_qty','measure','whole_sell_qty','whole_sell_discount','attributes']);
         $oldCart = Session::has('admin_cart') ? Session::get('admin_cart') : null;
         $cart = new Cart($oldCart);
         $cart->updateColor($prod,$id,$color);  
         Session::put('admin_cart',$cart);
    } 


    public function removecart($id)
    {
        $gs = Generalsetting::findOrFail(1);
        if (Session::has('currency')) 
        {
            $curr = Currency::find(Session::get('currency'));
        }
        else
        {
            $curr = Currency::where('is_default','=',1)->first();
        }
        $oldCart = Session::has('admin_cart') ? Session::get('admin_cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        if (count($cart->items) > 0) {
            Session::put('admin_cart', $cart);
                $data[0] = $cart->totalPrice;
                $data[3] = $data[0];
                    $tx = $gs->tax;
                    if($tx != 0)
                    {
                        $tax = ($data[0] / 100) * $tx;
                        $data[3] = $data[0] + $tax;
                    } 

                if($gs->currency_format == 0){
                    $data[0] = $curr->sign.round($data[0] * $curr->value,2);
                    $data[3] = $curr->sign.round($data[3] * $curr->value,2);
            
                }
                else{
                    $data[0] = round($data[0] * $curr->value,2).$curr->sign;
                    $data[3] = round($data[3] * $curr->value,2).$curr->sign;
                }
            
            $data[1] = count($cart->items); 
            return response()->json($data);  
        } else {
            Session::forget('admin_cart');
            Session::forget('already');
            Session::forget('coupon');
            Session::forget('coupon_total');
            Session::forget('coupon_total1');
            Session::forget('coupon_percentage');

            $data = 0;
            return response()->json($data); 
        }          
    } 

    public function coupon(Request $request)
    {
 
        $coupon_check_type = [];
        $code = $_GET['code'];
        $coupon = Coupon::where('code','=',$code)->first();
        $cart = Session::get('admin_cart');
        foreach($cart->items as $item){
           $product = Product::findOrFail($item['item']['id']);
           
           if($coupon->coupon_type == 'category'){
             
            if($product->category_id == $coupon->category){
                $coupon_check_type[] =1;
            }else{
               
                $coupon_check_type[] =0;
            }
           }elseif($coupon->coupon_type == 'sub_category'){
            if($product->subcategory_id == $coupon->sub_category){
                $coupon_check_type[] =1;
                
               
            }else{
                $coupon_check_type[] =0;
            }
           }elseif($coupon->coupon_type == 'child_category'){
            if($product->childcategory_id == $coupon->child_category){
                $coupon_check_type[] =1;
                
               
            }else{
                $coupon_check_type[] =0;
            }
           }else{
              
            $coupon_check_type[] =0;
           }
        
        }
        
       


        if(in_array(0,$coupon_check_type)){
            
            return response()->json(0);  
        }
       
        $gs = Generalsetting::findOrFail(1);
        
        $total = (float)preg_replace('/[^0-9\.]/ui','',$_GET['total']);;
        if(Session::has('is_tax')){
            $xtotal = ($total * Session::get('is_tax')) / 100;
            $total = $total + $xtotal ;
        }
     
        $fnd = Coupon::where('code','=',$code)->get()->count();
        if($fnd < 1)
        {
        return response()->json(0);              
        }
        else{
        $coupon = Coupon::where('code','=',$code)->first();
            if (Session::has('currency')) 
            {
              $curr = Currency::find(Session::get('currency'));
            }
            else
            {
                $curr = Currency::where('is_default','=',1)->first();
            }
        if($coupon->times != null)
        {
            if($coupon->times == "0")
            {
                return response()->json(0);                
            }
        }
        $today = date('Y-m-d');
        $from = date('Y-m-d',strtotime($coupon->start_date));
        $to = date('Y-m-d',strtotime($coupon->end_date));
        if($from <= $today && $to >= $today)
        {
            if($coupon->status == 1)
            {
                $oldCart = Session::has('admin_cart') ? Session::get('admin_cart') : null;
                $val = Session::has('already') ? Session::get('already') : null;
                if($val == $code)
                {
                    return response()->json(2); 
                }
                $cart = new Cart($oldCart);
                if($coupon->type == 0)
                {
                    Session::put('already', $code);
                    $coupon->price = (int)$coupon->price;
                    $val = $total / 100;
                    $sub = $val * $coupon->price;
                    $total = $total - $sub;
                    $data[0] = round($total,2);
                    if($gs->currency_format == 0){
                        $data[0] = $curr->sign.$data[0];
                    }
                    else{
                        $data[0] = $data[0].$curr->sign;
                    }
                    $data[1] = $code;      
                    $data[2] = round($sub, 2);
                    Session::put('coupon', $data[2]);
                    Session::put('coupon_code', $code);
                    Session::put('coupon_id', $coupon->id);
                    Session::put('coupon_total', $data[0]);
                    $data[3] = $coupon->id;
                    $data[4] = $coupon->price."%";
                    $data[5] = 1;

                    Session::put('coupon_percentage', $data[4]);

                    return response()->json($data);   
                }
                else{
                    Session::put('already', $code);
                    $total = $total - round($coupon->price * $curr->value, 2);
                    $data[0] = round($total,2);
                    $data[1] = $code;
                    $data[2] = round($coupon->price * $curr->value, 2);
                    Session::put('coupon', $data[2]);
                    Session::put('coupon_code', $code);
                    Session::put('coupon_id', $coupon->id);
                    Session::put('coupon_total', $data[0]);
                    $data[3] = $coupon->id;
                if($gs->currency_format == 0){
                    $data[4] = $curr->sign.$data[2];
                    $data[0] = $curr->sign.$data[0];
                }
                else{
                    $data[4] = $data[2].$curr->sign;
                    $data[0] = $data[0].$curr->sign;
                }
                    

                    Session::put('coupon_percentage', 0);

                    $data[5] = 1;
                    return response()->json($data);              
                }
            }
            else{
                    return response()->json(0);   
            }              
        }
        else{
        return response()->json(0);             
        }
        }         
    } 

    public function country_tax(Request $request)
    {
    
        if($request->country_id){
            if($request->state_id != 0 ){
                $state = State::findOrFail($request->state_id);
                $tax = $state->tax;
                $data[11] = $state->id ;
                $data[12] = 'state_tax';
            }else{
                $country = Country::findOrFail($request->country_id);
                $tax = $country->tax;
                $data[11] = $country->id;
                $data[12] = 'country_tax';
            }
           }else{
               $tax = 0;
           }
        
        Session::put('is_tax',$tax);

       
        $gs = Generalsetting::findOrFail(1);
       
        $total = (float)preg_replace('/[^0-9\.]/ui','',$_GET['total']);

        $stotal = ($total * $tax) / 100;

       
        Session::put('current_tax',$stotal);
      
        $total = $total + $stotal;

            if (Session::has('currency')) 
            {
              $curr = Currency::find(Session::get('currency'));
            }
            else
            {
                $curr = Currency::where('is_default','=',1)->first();
            }

            $data[0]= $total;
            $data[1] = $tax;
            if($gs->currency_format == 0){
                $data[0] = $curr->sign.$data[0];
            }
            else{
                $data[0] = $data[0].$curr->sign;
            }
            
            
            $data[0] = round($total,2);

            if(Session::has('coupon')){

                $data[0] = round($total - Session::get('coupon'),2);
            }
        
        return response()->json($data);              
        
    }

    public function couponcheck()
    {

        $coupon_check_type = [];
        $code = $_GET['code'];
        $coupon = Coupon::where('code','=',$code)->first();
        $cart = Session::get('admin_cart');
        foreach($cart->items as $item){
           $product = Product::findOrFail($item['item']['id']);
           
           if($coupon->coupon_type == 'category'){
             
            if($product->category_id == $coupon->category){
                $coupon_check_type[] =1;
            }else{
               
                $coupon_check_type[] =0;
            }
           }elseif($coupon->coupon_type == 'sub_category'){
            if($product->subcategory_id == $coupon->sub_category){
                $coupon_check_type[] =1;
                
               
            }else{
                $coupon_check_type[] =0;
            }
           }elseif($coupon->coupon_type == 'child_category'){
            if($product->childcategory_id == $coupon->child_category){
                $coupon_check_type[] =1;
                
               
            }else{
                $coupon_check_type[] =0;
            }
           }else{
              
            $coupon_check_type[] =0;
           }
        
        }
        
       


        if(in_array(0,$coupon_check_type)){
            
            return response()->json(0);  
        }

        
        $gs = Generalsetting::findOrFail(1);
        $code = $_GET['code'];
        $total = (float)preg_replace('/[^0-9\.]/ui','',$_GET['total']);
        if(Session::has('is_tax')){
            $xtotal = ($total * Session::get('is_tax')) / 100;
            $total = $total + $xtotal ;
        }
       
        $fnd = Coupon::where('code','=',$code)->get()->count();
        if($fnd < 1)
        {
        return response()->json(0);              
        }
        else{
        $coupon = Coupon::where('code','=',$code)->first();
            if (Session::has('currency')) 
            {
              $curr = Currency::find(Session::get('currency'));
            }
            else
            {
                $curr = Currency::where('is_default','=',1)->first();
            }
        if($coupon->times != null)
        {
            if($coupon->times == "0")
            {
                return response()->json(0);                
            }
        }
        $today = date('Y-m-d');
        $from = date('Y-m-d',strtotime($coupon->start_date));
        $to = date('Y-m-d',strtotime($coupon->end_date));
        if($from <= $today && $to >= $today)
        {
            if($coupon->status == 1)
            {
                $oldCart = Session::has('admin_cart') ? Session::get('admin_cart') : null;
                $val = Session::has('already') ? Session::get('already') : null;
                if($val == $code)
                {
                    return response()->json(2); 
                }
                $cart = new Cart($oldCart);
                if($coupon->type == 0)
                {
                    Session::put('already', $code);
                    $coupon->price = (int)$coupon->price;

                    $oldCart = Session::get('admin_cart');
                    $cart = new Cart($oldCart);

                    $total = $total - $_GET['shipping_cost'];

                    $val = $total / 100;
                    $sub = $val * $coupon->price;
                    $total = $total - $sub;
                    $total = $total + $_GET['shipping_cost'];
                    $data[0] = round($total,2);
                    $data[1] = $code;      
                    $data[2] = round($sub, 2);
                    if($gs->currency_format == 0){
                        $data[0] = $curr->sign.$data[0];
                    }
                    else{
                        $data[0] = $data[0].$curr->sign;
                    }
                    Session::put('coupon', $data[2]);
                    Session::put('coupon_code', $code);
                    Session::put('coupon_id', $coupon->id);
                    Session::put('coupon_total1', $data[0]);
                    Session::forget('coupon_total');
                    $data[0] = round($total,2);
                    $data[1] = $code;      
                    $data[2] = round($sub, 2);
                    $data[3] = $coupon->id;
                    $data[4] = $coupon->price."%";
                    $data[5] = 1;

                    Session::put('coupon_percentage', $data[4]);


                    return response()->json($data);   
                }
                else{
                    Session::put('already', $code);
                    $total = $total - round($coupon->price * $curr->value, 2);
                    $data[0] = round($total,2);
                    $data[1] = $code;
                    $data[2] = round($coupon->price * $curr->value, 2);
                    $data[3] = $coupon->id;
                    if($gs->currency_format == 0){
                        $data[4] = 0;
                        $data[0] = $curr->sign.$data[0];
                    }
                    else{
                        $data[4] = 0;
                        $data[0] = $data[0].$curr->sign;
                    }
                    Session::put('coupon', $data[2]);
                    Session::put('coupon_code', $code);
                    Session::put('coupon_id', $coupon->id);
                    Session::put('coupon_total1', $data[0]);
                    Session::forget('coupon_total');
                    $data[0] = round($total,2);
                    $data[1] = $code;
                    $data[2] = round($coupon->price * $curr->value, 2);
                    $data[3] = $coupon->id;                  
                    $data[5] = 1;

                    Session::put('coupon_percentage', $data[4]);

                    return response()->json($data);              
                }
            }
            else{
                return response()->json(0);   
            }              
        }
        else{
            return response()->json(0);             
            }
        }         
    } 



    public function get_state(Request $request)
    {
        $country = Country::findOrFail($request->country);
        $states = $country->states;

        return view('load.location',compact('states'));
    }

}