<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Study extends Model
{
    protected $table = 'studies';
    protected $fillable = [
        'building_id',
        'year',
        'carbon_footprint',
        'a1_gas_natural_kwh',
        'a1_gas_natural_nm3',
        'a1_refrigerantes',
        'a1_recarga_gases_refrigerantes',
        'a2_electricidad_kwh',
        'a3_agua_potable_m3',
        'a3_papel_carton_consumo_kg',
        'a3_papel_carton_residuos_kg',
        'a3_factor_kwh_nm3',
    ];

    public function building()
    {
        return $this->belongsTo('App\Models\Building');
    }

     public function carbon_footprint()
     {
         return $this->carbon_footprint();
     }
}
