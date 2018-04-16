<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detail_contract extends Model
{
    protected $casts = [
        'id_contract' => 'int',
        'id' => 'varchar'
    ];

    protected $dates = [
        'start_contract',
        'end_contract'
    ];
    protected $fillable = [
        'id',
        'id_contract',
        'start_contract',
        'end_contract',
        'urlContract',
        'isActive'
    ];

    public function contract()
    {
        return $this->belongsTo(\App\Models\Customer::class, 'id_contract');
    }

    public function detail()
    {
        return $this->hasMany(\App\Models\Detail::class, 'id_detail');
    }
}
