<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Classes\GeniusMailer;
use App\Models\Generalsetting;

class DeliveryBoy extends Authenticatable
{

    protected $fillable = ['name', 'photo', 'address', 'phone' , 'email','password','govt_id_proof','vehicle_number','commission','collection_amount','status','ban'];

    protected $table = 'delivery_boys';
    

}