<?php

namespace App\Http\Controllers;

use App\Models\CallTrade;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */

     public function __invoke(Request $request)
    {

        $total['customer'] = Customer::count();
        $total['activeCustomer'] = Customer::where(['status'=>'active'])->count();
        $total['callTrade'] = CallTrade::count();

        return view('dashboard',compact('total'));
    }
}
