<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ModuleFieldRequest;
use App\Models\ModuleField;
use Illuminate\Http\Request;

class ModuleFieldApiController extends Controller
{
    public function index(){
        ModuleField::latest()->get();
    }
    public function store(ModuleFieldRequest $request){
        $moduleField = ModuleField::create($request->all());
        return response()->json([
            'message' => 'ModuleField created successfully',
            'moduleField' => $moduleField,
        ], 201);
    }
}
