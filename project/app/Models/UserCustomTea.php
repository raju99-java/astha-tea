<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Currency;
use Illuminate\Support\Facades\Session;

class UserCustomTea extends Model
{

    protected $fillable = ['user_id','smell','color','weight','smell_per','color_per','price'];
    protected $table = 'user_custom_tea';
    



    


}
