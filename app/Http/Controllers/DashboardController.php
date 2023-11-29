<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Student;
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

        return view('dashboard');
    }
}
