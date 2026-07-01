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

    public function Add(Request $req)
    {
        $req->validate([
            'name' => 'required',
            'weight_kg' => 'required|numeric'
        ]);

        $fish = Fish::where('name', $req->name)->first();

        if ($fish) {
            return response()->json([
                'message' => 'Már létező hal'
            ], 409);
        }

        $data = new Fish();
        $data->name = $req->name;
        $data->weight_kg = $req->weight_kg;
        $data->save();

        return response()->json([
            'message' => 'Új hal sikeresen hozzáadva'
        ], 201);
    }

    public function Delete($id)
    {
        $fish = Fish::find($id);

        if (!$fish) {
            return response()->json([
                'message' => 'Hal nem található'
            ], 404);
        }

        $fish->delete();

        return response()->json([
            'message' => 'Hal sikeresen törölve'
        ], 200);
    }
}