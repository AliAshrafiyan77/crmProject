<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleField extends Model
{
    protected $fillable = [
        'module_name',
        'name',
        'code',
        'validates',
    ];
}
