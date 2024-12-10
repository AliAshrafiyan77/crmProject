<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kodeine\Metable\Metable;


class Customer extends Model
{
    use Metable;

    protected $metaTable = 'customers_meta';
//    protected $fillable = ['name', 'email', 'company_name', 'popularity'];
    public function getFillable()
    {
        return ModuleField::where('module_name', '=', 'customer')->pluck('code')->toArray();
    }

    protected $hidden = ['created_at', 'updated_at'];

    public function toArray(): array
    {
        return array_merge(parent::toArray(), $this->getMeta()->toArray());
    }

}
