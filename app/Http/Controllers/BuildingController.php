<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Building;
use App\Models\Country;
use App\Models\Region;
use App\Models\User;

class BuildingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showTutorial()
    {
        return redirect(route('building'))->with(['showTutorial' => true]);
    }

    public function showBuildings(Request $request)
    {
        // hacer query de los edificios
        $buildings = Building::where('user_id', Auth::id())->get();

        // devolver vista pasando los edificios
        return view('building.building', ['buildings' => $buildings]);
    }

    protected function buildingValidator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:35',
            'description' => 'nullable|string',
            'country_id' => 'required|exists:countries,id',
            'region_id' => 'required|exists:regions,id',
            'postcode' => 'required|numeric|max:99999',
            'address' => 'required|string',
        ]);
    }

    public function geocodeBuilding(Building $building)
    {
        $mapbox = new MapboxCurl();
        $lngLat = $mapbox->geocode($building);

        if ('array' == gettype($lngLat)) {
            $this->saveCoordinates($building, $lngLat);
        }
    }

    public function reverseGeocode(String $latitude, String $longitude)
    {
        $mapbox = new MapboxCurl();
        $reverseGeocode = $mapbox->reverseGeocode($latitude, $longitude);
        $geocode = array();

        foreach ($reverseGeocode->features as $feature) {
            $geocode[explode('.', $feature->id)[0]] = $feature->text;
        }

        return $geocode;
    }

    public function addBuilding(Request $request)
    {
        $validator = $this::buildingValidator($request->all());
        if ($validator->fails()) {
            return redirect(route('building'))->withErrors($validator)->withInput()->with(['showModal' => 'create']);
        }

        $building = Building::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'country_id' => $request->country_id,
            'region_id' => $request->region_id,
            'postcode' => $request->postcode,
            'address_with_number' => $request->address,
        ]);

        if ($request->input('latitude')) {
            $building->latitude = $request->input('latitude');
            $building->longitude = $request->input('longitude');
            $building->save();
        } else {
            $this->geocodeBuilding($building);
        }

        return redirect(route('building'));
    }

    public function editBuilding(Request $request)
    {
        $validator = $this::buildingValidator($request->all());

        if ($validator->fails()) {
            return redirect(route('building'))->withErrors($validator)->withInput()->with(['showModal' => 'edit']);
        }

        $building = Building::where('id', $request->id)->firstOrFail();
        $building->name = $request->input('name');
        $building->description = $request->input('description');
        $building->country_id = $request->input('country_id');
        $building->region_id = $request->input('region_id');
        $building->postcode = $request->input('postcode');
        $building->address_with_number = $request->input('address');

        if ($request->input('latitude')) {
            $building->latitude = $request->input('latitude');
            $building->longitude = $request->input('longitude');

            $this->setAddressFromCoordinates([
                $building->longitude = $request->input('longitude'),
                $building->latitude = $request->input('latitude'),
            ], $building);
        }
        $building->save();

        return redirect(route('building'));
    }

    public function deleteBuilding(Request $request, $id)
    {
        $building = Building::where('id', $id)->firstOrFail();
        $building->delete();

        return redirect(route('building'));
    }

    private function saveCoordinates(Building $building, array $lngLat)
    {
        $building->latitude = $lngLat[1];
        $building->longitude = $lngLat[0];
        $building->save();
    }

    private function setAddressFromCoordinates($lngLat, $building)
    {
        foreach ($this->reverseGeocode($lngLat[1], $lngLat[0]) as $type => $value) {
            switch ($type) {
                case 'address':
                    $building->address_with_number = $value;
                    break;

                case 'postcode':
                    $building->postcode = $value;
                    break;

                case 'region':
                    try {
                        $region = Region::where('name', ucwords(strtolower($value)))->first();
                        $building->region_id = $region->id;
                    } catch (Exception $e) {
                        $building->region_id = null;
                    }
                    break;

                case 'country':
                    try {
                        $country = Country::where('name', ucwords(strtolower($value)))->first();
                        $building->country_id = $country->id;
                    } catch (Exception $e) {
                        $building->country_id = null;
                    }
                break;
            }
        }
    }

    public function showStats($id = null)
    {
        if (!$id) {
            $buildings = Auth::user()->buildings;
        } else {
            $buildings = Auth::user()->buildings()->where('id', $id)->get();

            if (0 == count($buildings)) {
                abort(404);
            }
        }

        return view('building.stats', ['buildings' => $buildings, 'year' => date('Y')]);
    }
}
