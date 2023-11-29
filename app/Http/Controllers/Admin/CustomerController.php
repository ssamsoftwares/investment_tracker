<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CallTrade;
use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class CustomerController extends Controller
{

    public function customers(Request $request)
    {
        $search = $request->input('search');
        $customer = Customer::when($search, function ($query) use ($search) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('first_name', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%')
                ->orWhere('city', 'like', '%' . $search . '%')
                ->orWhere('status', 'like', $search . '%');
        })->paginate(10);

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


    public function view(Customer $customer)
    {
        $cus_id = $customer->id;
        $callTrades = CallTrade::whereJsonContains('customer_ids', (string)$cus_id)->paginate(10);
        return view('admin.customer.view', compact('customer', 'callTrades'));
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
            'email' => 'required|max:255|unique:customers,email,except' . $customer->id,
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
}
