<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 23 Feb 2018 09:24:59 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Detail
 * 
 * @property int $idDetails
 * @property int $id_contract
 * @property int $id_vehicle
 * @property int $id_type_clients_subscribe
 * @property int $id_boxe
 * @property float $price
 * @property bool $offer
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\Box $box
 * @property \App\Models\Contract $contract
 * @property \App\Models\TypesClientsSubscribe $types_clients_subscribe
 * @property \App\Models\Vehicle $vehicle
 *
 * @package App\Models
 */
class Detail extends Eloquent
{
	protected $primaryKey = 'idDetails';

	protected $casts = [
		'id_contract' => 'int',
		'id_vehicle' => 'int',
		'id_type_clients_subscribe' => 'int',
		'id_boxe' => 'int',
		'price' => 'float',
		'offer' => 'bool'
	];

	protected $fillable = [
		'id_contract',
		'id_vehicle',
		'id_type_clients_subscribe',
		'id_boxe',
		'price',
		'offer'
	];

	public function box()
	{
		return $this->belongsTo(\App\Models\Box::class, 'id_boxe');
	}

	public function contract()
	{
		return $this->belongsTo(\App\Models\Contract::class, 'id_contract');
	}

	public function types_clients_subscribe()
	{
		return $this->belongsTo(\App\Models\TypesClientsSubscribe::class, 'id_type_clients_subscribe');
	}

	public function vehicle()
	{
		return $this->belongsTo(\App\Models\Vehicle::class, 'id_vehicle');
	}
}
