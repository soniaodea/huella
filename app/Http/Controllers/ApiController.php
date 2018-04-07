<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Building;
use Auth;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkOwner')->only([
            'updateBuilding',
            'deleteBuilding',
        ]);
    }

    // Buildings
    public function showAllBuildings()
    {
        return Auth::user()->buildings;
    }

    public function showBuilding(Building $building)
    {
        return Auth::user()->buildings()->find($building);
    }

    public function storeBuilding(Request $request)
    {
        $building = Building::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'country_id' => $request->country_id,
            'region_id' => $request->region_id,
            'postcode' => $request->postcode,
            'address_with_number' => $request->address_with_number,
        ]);

        return response()->json($building, 201);
    }

    public function updateBuilding(Request $request, Building $building)
    {
        $building->update($request->all());

        return response()->json($building, 200);
    }

    public function deleteBuilding(Building $building)
    {
        $building->delete();

        return response()->json(null, 204);
    }
}
