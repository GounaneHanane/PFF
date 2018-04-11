<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 27 Feb 2018 10:31:31 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Contract
 * 
 * @property int $id
 * @property int $id_customer
 * @property \Carbon\Carbon $start_date
 * @property \Carbon\Carbon $end_date
 * @property string $urlContract
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\Customer $customer
 * @property \Illuminate\Database\Eloquent\Collection $details
 *
 * @package App\Models
 */
class Contract extends Eloquent
{
	protected $casts = [
		'id_customer' => 'int',
        'id' => 'varchar'
	];

	protected $dates = [
		'start_contract',
		'end_contract'
	];

	protected $fillable = [
        'id',
		'id_customer',
		'start_contract',
		'end_contract',
		'urlContract',
        'isActive'
	];

	public function customer()
	{
		return $this->belongsTo(\App\Models\Customer::class, 'id_customer');
	}

	public function renouvelement()
	{
		return $this->hasMany(\App\Models\Detail::class, 'id_contract');
	}
}
