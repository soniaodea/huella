<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Building;
use App\Models\Study;
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

    //Modu hau MySQL-kin badabil baina POSTGRES-ekin ez
    //public function showBuilding(Building $building)
    public function showBuilding($building)
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

    //Alcances
    public function showAlcances($building)
    {
        $authBuilding = Auth::user()->buildings()->find($building);
        return response()->json($authBuilding->studies()->where('building_id',$building)->get());



        //Building::with($building)->studies()->
        //$variable = Product::with('designs')->find(1);
        //return response()->json(Study::where('building_id',$building));

        //return Study::with(Auth::user()->buildings()->find($building))->findAll();
        //return Auth::user()->buildings()->find($building);

        //return Auth::user()->buildings()->find($building);
        //return response()->json($building, 200);
    }
}
