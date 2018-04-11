<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 27 Feb 2018 10:31:31 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Box
 * 
 * @property int $id
 * @property string $reference
 * @property string $type_box
 * @property string $numero_operetor
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $details
 *
 * @package App\Models
 */
class Renouvelement extends Eloquent
{	protected $casts = [
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
