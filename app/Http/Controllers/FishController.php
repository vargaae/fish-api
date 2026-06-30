<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fish;

class FishController extends Controller
{
    public function All()
    {
        return response()->json([
            'message' => 'Halak listája',
            'data' => Fish::all(),
        ], 200);
    }

    public function Add()
    {

    }
    public function Delete()
    {

    }
}