<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Currency;
use Illuminate\Support\Facades\Session;

class CustomTea extends Model
{

    protected $fillable = ['name','type','price','stock','status'];
    protected $table = 'custom_tea';
    


    public  function setCurrency() {
        $gs = cache()->remember('generalsettings', now()->addDay(), function () {
            return DB::table('generalsettings')->first();
        });
        $price = $this->price;
        if (Session::has('currency'))
        {
            $curr = cache()->remember('session_currency', now()->addDay(), function () {
                return DB::table('currencies')->find(Session::get('currency'));
            });
        }
        else
        {
            $curr = cache()->remember('default_currency', now()->addDay(), function () {
                return DB::table('currencies')->where('is_default','=',1)->first();
            });
        }
        $price = round($price * $curr->value,2);
        if($gs->currency_format == 0){
            return $curr->sign.$price;
        }
        else{
            return $price.$curr->sign;
        }
    }


    public function showPrice() {
        $gs = cache()->remember('generalsettings', now()->addDay(), function () {
            return DB::table('generalsettings')->first();
        });
        $price = $this->price;

        if($this->user_id != 0){
        if($this->category->commission != 0){
                $price = $this->price + $this->price * $this->category->commission / 100 ;
            }else{
                $price = $this->price + $gs->fixed_commission + ($this->price/100) * $gs->percentage_commission ;
            }
        }

        if(!empty($this->size) && !empty($this->size_price)){
            $price += $this->size_price[0];
        }
        
    // Attribute Section

    $attributes = $this->attributes["attributes"];
      if(!empty($attributes)) {
          $attrArr = json_decode($attributes, true);
      }
     
      if (!empty($attrVal['values']) && is_array($attrVal['values'])) {
          foreach ($attrArr as $attrKey => $attrVal) {
            if (is_array($attrVal) && array_key_exists("details_status",$attrVal) && $attrVal['details_status'] == 1) {

                foreach ($attrVal['values'] as $optionKey => $optionVal) {
                  $price += $attrVal['prices'][$optionKey];
                  // only the first price counts
                  break;
                }

            }
          }
      }


    // Attribute Section Ends


    if (Session::has('currency'))
    {
        $curr = cache()->remember('session_currency', now()->addDay(), function () {
            return DB::table('currencies')->find(Session::get('currency'));
        });
    }
    else
    {
        $curr = cache()->remember('default_currency', now()->addDay(), function () {
            return DB::table('currencies')->where('is_default','=',1)->first();
        });
    }
 


        $price = round(($price) * $curr->value,2);
        if($gs->currency_format == 0){
            return $curr->sign.$price;
        }
        else{
            return $price.$curr->sign;
        }
    }

    

    public static function convertPrice($price) {
        $gs = cache()->remember('generalsettings', now()->addDay(), function () {
            return DB::table('generalsettings')->first();
        });
        if (Session::has('currency'))
        {
            $curr = cache()->remember('session_currency', now()->addDay(), function () {
                return DB::table('currencies')->find(Session::get('currency'));
            });
        }
        else
        {
            $curr = cache()->remember('default_currency', now()->addDay(), function () {
                return DB::table('currencies')->where('is_default','=',1)->first();
            });
        }
        $price = round($price * $curr->value,2);
        if($gs->currency_format == 0){
            return $curr->sign.$price;
        }
        else{
            return $price.$curr->sign;
        }
    }

    

    public function showName() {
        $name = mb_strlen($this->name,'utf-8') > 55 ? mb_substr($this->name,0,55,'utf-8').'...' : $this->name;
        return $name;
    }


    public function emptyStock() {
        $stck = (string)$this->stock;
        if($stck == "0"){
            return true;            
        }
    }

    


}
