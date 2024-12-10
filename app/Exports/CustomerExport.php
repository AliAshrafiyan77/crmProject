<?php

namespace App\Exports;

use App\Models\Customer;
use App\Models\ModuleField;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Customer::all()->map(function ($customer) {
            return $customer->toArray(); // Apply toArray with custom logic
        });
    }

    public function headings(): array
    {
        return array_keys($this->collection()->first());
    }
}
