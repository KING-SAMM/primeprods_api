<?php

namespace App\Http\Controllers\Api;

use App\Models\Prototype;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PrototypeController extends Controller
{
    /**
     *  Get all prototypes
     * 
     * @return array<string>
     */
    public function index()
    {
        return response()->json([
            'prototypes' => Prototype::latest()->filter(request(['tag', 'search']))->paginate(10)
        ]);
    }


    /**
     * Get all prototypes (gallery)
     * 
     * @return array<string>
     */
    public function gallery()
    {
        return response()->json([
            'prototypes' => Prototype::all(),
            'heading' => 'Gallery'
        ]);
    }


    /**
     * Get single prototype
     * 
     * @return array<string>
     */
    public function show(Prototype $prototype)
    {
        return response()->json([
            'prototype' => $prototype
        ]);
    }
}
