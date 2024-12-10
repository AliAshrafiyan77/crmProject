<?php

namespace App\Imports;

use App\Models\Customer;
use App\Models\ModuleField;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class CustomerImport implements  ToCollection
{
    /**
    *
     *
     *
    */
    public function collection(Collection $rows)
    {
        $headers = $rows->first();
        $headers = $headers->toArray();
        foreach ($rows as $index => $row) {
            if ($index === 0) {
                continue;
            }
            $customerData = [];
            foreach ($row as $key => $value) {
                $customerData[$headers[$key]] = $value;
            }
            $customer = Customer::create($customerData);
        }
    }
}
