<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CallTrade;
use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Log;

class CustomerController extends Controller
{


    public function customers(Request $request)
    {
        $searchTerm = $request->input('search');
        $searchTerms = explode(' ', $searchTerm);

        $customer = Customer::where(function ($query) use ($searchTerms) {
            foreach ($searchTerms as $term) {
                $query->where('title', 'like', '%' . $term . '%')
                    ->orWhere('first_name', 'like', '%' . $term . '%')
                    ->orWhere('last_name', 'like', '%' . $term . '%')
                    ->orWhere('email', 'like', '%' . $term . '%')
                    ->orWhere('phone', 'like', '%' . $term . '%')
                    ->orWhere('city', 'like', '%' . $term . '%')
                    ->orWhere('status', 'like', '%' . $term . '%');
            }
        });

        $customer = $customer->paginate(10);

        return view('admin.customer.all', compact('customer'));
    }


    public function create()
    {
        return view('admin.customer.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|max:255|unique:customers,email,except,id',
            'phone' => 'required|max:255',
            'address' => 'required|max:255',
            'city' => 'required|max:255',
            'state' => 'required|max:255',
            'zip' => 'required|max:10',
            'adhaar_number' => 'required|max:20',
            'pan_number' => 'required|max:12',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->all();
            Customer::create($data);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('status', $e->getMessage());
        }
        DB::commit();
        return redirect()->back()->with('status', "Customer Created Successfully !");
    }



    public function view(Request $request, Customer $customer)
    {
        $cus_id = $customer->id;
        $query = CallTrade::whereJsonContains('customer_ids', (string)$cus_id);
        // Apply date range filter
        if ($request->has('from_date') && $request->has('to_date')) {
            $from_date = $this->validateAndParseDate($request->input('from_date'));
            $to_date = $this->validateAndParseDate($request->input('to_date'));

            if ($from_date && $to_date) {
                $query->whereBetween('created_at', [$from_date->startOfDay(), $to_date->endOfDay()]);
            }
        }

        // Apply search
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('trade_name', 'like', '%' . $search . '%')
                    ->orWhere('amount', 'like', '%' . $search . '%')
                    ->orWhere('commission', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', $search . '%');

                $dateSearch = $this->validateAndParseDate($search);
                if ($dateSearch) {
                    $query->orWhereDate('created_at', '=', $dateSearch);
                }
            });
        }

        // Apply weekly or monthly filter
        $filter = $request->input('commition_filter');
        if ($filter == 'weekly') {
            $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($filter == 'monthly') {
            $query->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
        }

        $callTrades = $query->paginate(10);

        // Calculate total amount and total commission
        $totalAmount = $query->sum('amount');
        $totalCommission = $query->sum('commission');

        return view('admin.customer.view', compact('customer', 'callTrades', 'totalAmount', 'totalCommission'));
    }


    private function validateAndParseDate($dateString)
    {
        try {
            $parsedDate = Carbon::parse($dateString);
            return $parsedDate->isValid() ? $parsedDate : null;
        } catch (\Exception $e) {
            // dd("Catch any parsing exception and return null");
            return null;
        }
    }


    public function edit(Customer $customer)
    {
        return view('admin.customer.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'title' => 'required',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|max:255|unique:customers,email,' . $customer->id,
            'phone' => 'required|max:255',
            'address' => 'required|max:255',
            'city' => 'required|max:255',
            'state' => 'required|max:255',
            'zip' => 'required|max:10',
            'adhaar_number' => 'required|max:20',
            'pan_number' => 'required|max:12',
        ]);
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['status'] = $request->status ?? 'inactive';
            $customer->update($data);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('status', $e->getMessage());
        }
        DB::commit();
        return redirect()->back()->with('status', "Customer Updated Successfully !");
    }


    public function destroy(Customer $customer)
    {
        DB::beginTransaction();
        try {
            $customer->delete();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('status', $e->getMessage());
        }
        DB::commit();
        return redirect()->back()->with('status', "Customer deleted Successfully !");
    }

    public function customerUpdateStatus($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->status = ($customer->status === 'inactive') ? 'active' : 'inactive';
        $customer->save();
        return redirect()->back()->with('status', 'Status change successfull .!');
    }

    public function activeCustomers(Request $request)
    {
        $search = $request->input('search');

        $activeCustomers = Customer::where('status', 'active')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subquery) use ($search) {
                    $subquery->orWhere('title', 'like', '%' . $search . '%')
                        ->orWhere('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%')
                        ->orWhere('city', 'like', '%' . $search . '%');
                });
            })->paginate(10);

        return view('admin.customer.active_customer', compact('activeCustomers'));
    }


    public function statistics(Request $request, Customer $customer)
    {
        $query = CallTrade::query();
        // Apply date range filter
        if (!empty($request->from_date) && !empty($request->to_date)) {
            $from_date = $this->validateAndParseDate($request->input('from_date'));
            $to_date = $this->validateAndParseDate($request->input('to_date'));

            if ($from_date && $to_date) {
                $query->whereBetween('created_at', [$from_date->startOfDay(), $to_date->endOfDay()]);
            }
        }

        // Apply search
        if (!empty($request->search)) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('trade_name', 'like', '%' . $search . '%')
                    ->orWhere('amount', 'like', '%' . $search . '%')
                    ->orWhere('commission', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', $search . '%');

                $dateSearch = $this->validateAndParseDate($search);
                if ($dateSearch) {
                    $query->orWhereDate('created_at', '=', $dateSearch);
                }
            });
        }

        // Apply weekly or monthly filter
        $filter = $request->input('commition_filter');
        if ($filter == 'weekly') {
            $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($filter == 'monthly') {
            $query->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
        }

        // Calculate total amount and total commission
        $totalAmount = $query->sum('amount');
        $totalCommission = $query->sum('commission');

        $callTrades = $query->paginate(10);

        return view('admin.customer.statistics', compact('customer', 'callTrades', 'totalAmount', 'totalCommission'));
    }
}
