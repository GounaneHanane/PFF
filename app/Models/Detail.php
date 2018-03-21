<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 27 Feb 2018 10:31:31 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Detail
 * 
 * @property int $id
 * @property int $id_contract
 * @property int $id_vehicle
 * @property int $id_type_customer_subscribe
 * @property int $id_boxe
 * @property float $price
 * @property bool $offer
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\Box $box
 * @property \App\Models\Contract $contract
 * @property \App\Models\TypesCustomersSubscribe $types_customers_subscribe
 * @property \App\Models\Vehicle $vehicle
 *
 * @package App\Models
 */
class Detail extends Eloquent
{
	protected $casts = [
		'id_contract' => 'int',
		'id_vehicle' => 'int',
		'id_type_customer_subscribe' => 'int',
		'price' => 'float',
		'offer' => 'bool'
	];

	protected $fillable = [
		'id_contract',
		'id_vehicle',
		'id_type_customer_subscribe',

		'price',
		'offer'
	];



	public function contract()
	{
		return $this->belongsTo(\App\Models\Contract::class, 'id_contract');
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
