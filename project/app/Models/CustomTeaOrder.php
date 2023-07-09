<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomTeaOrder extends Model
{
	protected $fillable = ['order_type','salesman_id','deliver_by','user_id', 'p1', 'p1_percent','p1_price','p1_weight','p2','p2_percent','p2_price','p2_weight','total_price', 'method','shipping','totalweight', 'pay_amount', 'wallet_price','txnid', 'order_number', 'payment_status', 'customer_email', 'customer_name', 'customer_phone', 'customer_address', 'customer_city', 'customer_zip','shipping_name', 'shipping_email', 'shipping_phone', 'shipping_address', 'shipping_city', 'shipping_zip', 'order_note','coupon_code','coupon_discount', 'status','currency_sign','currency_value','shipping_cost','dp','wallet_reward','rating','comment'];
    protected $table = 'customtea_orders';
    public function smell() {
        return $this->belongsTo('App\Models\CustomTea', 'p1', 'id');
    }
    public function colour() {
        return $this->belongsTo('App\Models\CustomTea', 'p2', 'id');
    }

}
