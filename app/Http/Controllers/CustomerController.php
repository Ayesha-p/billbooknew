<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private function rules(): array
    {
        return ['name' => 'required|string|max:120', 'email' => 'nullable|email', 'phone' => 'nullable|string|max:30', 'address' => 'nullable|string|max:300'];
    }

    public function index() { return view('customers.index', ['customers' => Customer::latest()->get()]); }
    public function create() { return view('customers.form', ['customer' => new Customer]); }

    public function store(Request $r)
    {
        Customer::create($r->validate($this->rules()));
        return redirect()->route('customers.index')->with('ok', 'Customer add ho gaya.');
    }

    public function edit(Customer $customer) { return view('customers.form', compact('customer')); }

    public function update(Request $r, Customer $customer)
    {
        $customer->update($r->validate($this->rules()));
        return redirect()->route('customers.index')->with('ok', 'Customer update ho gaya.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return back()->with('ok', 'Customer (aur uske invoices) delete ho gaye.');
    }
}
