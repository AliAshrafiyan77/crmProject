<?php

namespace App\Http\Controllers\Api;

use App\Exports\Customer1Export;
use App\Exports\CustomerExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Imports\CustomerImport;
use App\Models\Customer;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CustomerApiController extends Controller
{
    public function index(){
        return Customer::get();
    }
    public function store(CustomerRequest $request){
        $customer = Customer::create($request->all());
        return response()->json([
            'message' => 'Customer created successfully',
            'customer' => $customer,
        ], 201);
    }
    public function export(){
//        return Excel::download(new CustomerExport, 'customers.xlsx' ,  \Maatwebsite\Excel\Excel::XLSX);
        return Excel::download(new Customer1Export, 'customers.xlsx' ,  \Maatwebsite\Excel\Excel::XLSX);
    }

    public function import(Request $request)
    {
        info($request->all());
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);
        Excel::import(new CustomerImport, $request->file('file'));

        return response()->json(['message' => 'ایمپورت فایل با موفقیت انجام شد'], 200);
    }
}
