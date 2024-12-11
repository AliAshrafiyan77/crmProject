<?php

namespace App\Exports;

use App\Models\Customer;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;


class Customer1Export implements FromQuery, WithHeadings
{
    use Exportable;
    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return Customer::query();
    }
    /**
     * فرآیند تبدیل به آرایه
     */
    public function collection()
    {
        return Customer::query()->get()->map(function ($customer) {
            $data = $customer->toArray();
            info($data);
            return $data;
        });
    }

    /**
     *
     * @return array
     */
    public function headings(): array
    {
        $firstCustomer = $this->collection()->first();
        return $firstCustomer ? array_keys($firstCustomer) : [];
    }
}
