<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerApiController extends Controller
{
    public function index(){
        return Customer::with('phoneNumbers')->get();
    }
    public function store(Request $request){
        $validated = $request->validate([
            'name' => ['required' , 'min:2' , 'max:255'],
            'email' => ['required' , 'email'],
            'companyName' => ['nullable' , 'min:3' , 'max:255'],
            'popularity' => ['nullable'],
            'phoneNumbers' => ['required','array'],
            'phoneNumbers.*' => ['required' , 'digits_between:11,15' , 'min:11'],
            'address' => ['required', 'string', 'max:255'],
        ]);
         $popularity = 0;
         if ($request->popularity){
             $popularity = $request->popularity;
         }elseif (!$request->popularity){
             $popularity = 0;
         }
        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'companyName' => $request->companyName,
            'popularity' => $popularity,
        ]);
        foreach ($request->phoneNumbers as $phoneNumber) {
            $customer->phoneNumbers()->create([
                'phone_number' => $phoneNumber,
            ]);
        }
        $customer->meta()->create([
            'customer_id' => $customer->id,
            'key' => 'address',
            'value' => $request->address,
        ]);
        info($request->all());
        return response()->json([
            'message' => 'Customer created successfully',
            'customer' => $customer,
            'phone_numbers' => $customer->phoneNumbers,
        ], 201);
    }
}
