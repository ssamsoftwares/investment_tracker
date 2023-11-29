<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CallTrade;
use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;

class CallTradeController extends Controller
{
    public function callTrade(Request $request)
    {
        $search = $request->input('search');
        $callTrade = CallTrade::when($search, function ($query) use ($search) {
            $query->where('trade_name', 'like', '%' . $search . '%')
                ->orWhere('amount', 'like', '%' . $search . '%');
        })->paginate(10);


        return view('admin.callTrade.all', compact('callTrade'));
    }

    public function view(CallTrade $callTrade, $id)
    {
        $callTrade = CallTrade::find($id);
        $customerIds = json_decode($callTrade->customer_ids);
        $customers = Customer::whereIn('id', $customerIds)->paginate(10);
        return view('admin.callTrade.view', compact('callTrade', 'customers'));
    }

    public function create()
    {
        return view('admin.callTrade.call_trade');
    }

    public function createTradeNextBtn(Request $request)
    {
        $request->validate([
            'selected_customers' => 'required|array',
            'selected_customers.*' => 'exists:customers,id',
        ]);
        $selectedCustomerIds = $request->input('selected_customers');
        $selectedCustomers = Customer::whereIn('id', $selectedCustomerIds)->get();
        // Session::put('selectedCustomers', $selectedCustomers);
        $tradeView = View::make('admin.callTrade.call_trade', compact('selectedCustomers'));
        return $tradeView;
    }

    public function storeTrade(Request $request)
    {
        $request->validate([
            'trade_name' => 'required|string',
            'amount' => 'required|numeric',
            'customer_ids' => 'required|array',
            'customer_ids.*' => 'exists:customers,id',
        ]);
        DB::beginTransaction();
        try {
            // Create a new trade
            $trade = CallTrade::create([
                'trade_name' => $request->input('trade_name'),
                'amount' => $request->input('amount'),
                'customer_ids' => json_encode($request->input('customer_ids')),
            ]);
            // Session::forget('selectedCustomers');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('status', $e->getMessage());
        }
        DB::commit();
        return redirect()->route('callTrades')->with('status', 'Call Trade Created Successfully !');

    }

    public function destroy(CallTrade $callTrade)
    {
        DB::beginTransaction();
        try {
            $callTrade->delete();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('status', $e->getMessage());
        }
        DB::commit();
        return redirect()->back()->with('status', 'Call Trade Deleted Successfully !');
    }
}
