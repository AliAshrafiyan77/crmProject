<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kodeine\Metable\Metable;


class Customer extends Model
{
    use Metable;
    protected $metaTable = 'customers_meta';
    protected $metaKeyName = 'customer_id';
    protected $fillable = [
        'name',
        'email',
        'companyName',
        'popularity',
    ];
    public function phoneNumbers()
    {
        return $this->hasMany(PhoneNumber::class);
    }
//    public function meta()
//    {
//        return $this->hasMany('App\Models\CustomerMeta', 'customer_id');
//    }
}
