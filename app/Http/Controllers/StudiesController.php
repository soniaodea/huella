<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Building;
use App\Models\Study;
use App\Models\User;

class StudiesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function alcancesView($id)
    {
        return view('user.alcances', ['id' => $id, 'studies' => Building::find($id)->studies()->whereNotNull('carbon_footprint')->orderBy('year', 'asc')->get(), 'action' => 'view']);
    }

    public function alcancesCreate($id)
    {
        return view('user.alcances', ['id' => $id, 'studies' => Building::find($id)->studies()->whereNull('carbon_footprint')->orderBy('year', 'asc')->get(), 'action' => 'create']);
    }

    public function alcances(Request $request)
    {
        $validator = $this::alcancesValidator($request->all());
        if ($validator->fails()) {
            $validator->errors()->add('inputYear', $request->year);

            return redirect()->back()->withErrors($validator)->withInput();
        }
        $alcances = Study::updateOrCreate([
             'building_id' => $request->building_id,
             'year' => $request->year,
         ], [
             'a1_gas_natural_kwh' => $request->a1_gas_natural_kwh,
             'a1_gas_natural_nm3' => $request->a1_gas_natural_nm3,
             'a1_refrigerantes' => $request->a1_refrigerantes,
             'a1_recarga_gases_refrigerantes' => $request->a1_recarga_gases_refrigerantes,
             'a2_electricidad_kwh' => $request->a2_electricidad_kwh,
             'a3_agua_potable_m3' => $request->a3_agua_potable_m3,
             'a3_papel_carton_consumo_kg' => $request->a3_papel_carton_consumo_kg,
             'a3_papel_carton_residuos_kg' => $request->a3_papel_carton_residuos_kg,
             'a3_factor_kwh_nm3' => $request->a3_factor_kwh_nm3,
         ]);
        if ('calculateStudy' == $request->input('submit')) {
            $this->calculateStudy($alcances);

            return redirect(route('alcancesView', ['id' => $request->building_id]))->with(['showYear' => $request->year]);
        }

        return redirect(route('alcancesCreate', ['id' => $request->building_id]))->with(['showYear' => $request->year]);
    }

    protected function alcancesValidator(array $data)
    {
        $validator = Validator::make($data, [
             'building_id' => 'required',
             'year' => [
                 'required',
                 'numeric',
                 'min:'.(date('Y') - 20),
                 'max:'.date('Y'),
             ],
             'a1_gas_natural_kwh' => 'required|numeric',
             'a1_gas_natural_nm3' => 'required|numeric',
             'a1_refrigerantes' => 'required|numeric',
             'a1_recarga_gases_refrigerantes' => 'required|numeric',
             'a2_electricidad_kwh' => 'required|numeric',
             'a3_agua_potable_m3' => 'required|numeric',
             'a3_papel_carton_consumo_kg' => 'required|numeric',
             'a3_papel_carton_residuos_kg' => 'required|numeric',
             'a3_factor_kwh_nm3' => 'required|numeric',
         ]);
        // validate year field (create)
        $validator->sometimes('year', Rule::unique('studies')->where('building_id', $data['building_id']), function ($input) {
            return empty($input->id);
        });
        // validate year field (update)
        $validator->sometimes('year', Rule::unique('studies')->where('building_id', $data['building_id'])->ignore($data['id'], 'id'), function ($input) {
            return !empty($input->id);
        });

        return $validator;
    }

    /**
     * Calculo huella.
     */
    public function calculateStudy(Study $study)
    {
        $formula =
            $study->a1_gas_natural_kwh
            + $study->a1_gas_natural_nm3
            + $study->a1_refrigerantes
            + $study->a1_recarga_gases_refrigerantes
            + $study->a2_electricidad_kwh
            + $study->a3_agua_potable_m3
            + $study->a3_papel_carton_consumo_kg
            + $study->a3_papel_carton_residuos_kg
            + $study->a3_factor_kwh_nm3;
        $study->carbon_footprint = $formula;
        $study->save();
    }
}
