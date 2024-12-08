<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    protected $fillable = [
        'customer_id',
        'phone_number',
    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
