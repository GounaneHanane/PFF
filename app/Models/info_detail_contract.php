<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class info_detail_contract extends Eloquent
{
   public $table='info_detail_contract';
    protected $casts = [
        'id_detail' => 'int',
        'id_vehicle' => 'int',
        'id_type_customer_subscribe' => 'int',
        'price' => 'float',
        'offer' => 'bool',
        'AddingDate' => 'date'
    ];

    protected $fillable = [
        'id_detail',
        'id_vehicle',
        'id_type_customer_subscribe',
        'price',
        'offer',
        'AddingDate'
    ];



    public function detail_contract()
    {
        return $this->belongsTo(\App\Models\detail_contract::class, 'id_detail');
    }

    public function types_customers_subscribe()
    {
        return $this->belongsTo(\App\Models\TypesCustomersSubscribe::class, 'id_type_customer_subscribe');
    }

    public function vehicle()
    {
        return $this->belongsTo(\App\Models\Vehicle::class, 'id_vehicle');
    }
}
