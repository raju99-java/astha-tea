<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Generalsetting as GS;
use App\Models\Currency;
use App\Models\PaymentGateway;
use App\Models\Transaction;
use Faker\Provider\ar_SA\Payment;
use Session;

class DepositController extends Controller
{
    public function index() {
      return view('user.deposit.index');
    }

    public function transactions() {
      return view('user.transactions');
    }

    public function transhow($id)
    {
      $data = Transaction::find($id);
      return view('load.transaction-details',compact('data'));
    }

    public function create() {
      if (Session::has('currency'))
      {
        $data['curr'] = Currency::find(Session::get('currency'));
      }
      else
      {
        $data['curr'] = Currency::where('is_default','=',1)->first();
      }

      $paystack = PaymentGateway::whereKeyword('paystack')->first();
      $data['paystackData'] = $paystack->convertAutoData();
      
      $data['gateways'] = PaymentGateway::where('type','automatic')->where('is_deposite',1)->get();
      return view('user.deposit.create',$data);
    }

}
