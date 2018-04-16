<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class detail_contract extends Eloquent
{
    public $table='detail_contract';
    protected $casts = [
        'id_contract' => 'int'
    ];

    protected $dates = [
        'start_contract',
        'end_contract'
    ];
    protected $fillable = [
        'id_contract',
        'start_contract',
        'end_contract',
        'urlPdf',
        'isActive',
        'matricule',
        'nbAvance',
        'nbSimple' ,
        'defaultAvance',
        'defaultSimple',
        'price',
        'status'
    ];

    public function contract()
    {
        return $this->belongsTo(\App\Models\Contract::class, 'id_contract');
    }

    public function info_detail_contract()
    {
        return $this->hasMany(\App\Models\info_detail_contract::class, 'id_detail');
    }
}
