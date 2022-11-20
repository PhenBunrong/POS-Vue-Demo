<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;


class CustomerController extends Controller
{

    public function index()
    {
        return view('customer');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=> 'required|string|max:255',
            'phone'=> 'required|string|max:255',
            'address'=> 'required|string|max:255',
        ]);


        $customer = Customer::create([
            'name' => $request['name'],
            'gender' => $request['gender'],
            'phone' => $request['phone'],
            'address' => $request['address'],
        ]);
        
        return response()->json(['message' =>"Customer's $customer->name save compelete."]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'=> 'required|string|max:255',
            'phone'=> 'required|string|max:255',
            'address'=> 'required|string|max:255',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($request->all());

        return response()->json(['message' => 'Completed']);
    }

    public function destroy($id)
    {
        Customer::destroy($id);
    }
    
    public function getRow(){
        $customer = Customer::orderBy('id','desc')->paginate(5);

        return $customer;
    }
}
