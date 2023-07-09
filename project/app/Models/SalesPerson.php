<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Classes\GeniusMailer;
use App\Models\Generalsetting;

class SalesPerson extends Authenticatable
{

    protected $fillable = ['name', 'photo', 'address', 'phone' , 'email','password','commission','govt_id_proof','status','ban'];

    protected $table = 'sales_person';
    

}