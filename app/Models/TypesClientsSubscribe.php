<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 23 Feb 2018 09:24:59 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TypesClientsSubscribe
 * 
 * @property int $idTypesClientsSubscribe
 * @property int $id_type_client
 * @property int $id_subscribe
 * @property float $price
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\Subscribe $subscribe
 * @property \App\Models\TypesClient $types_client
 * @property \Illuminate\Database\Eloquent\Collection $details
 *
 * @package App\Models
 */
class TypesClientsSubscribe extends Eloquent
{
	protected $table = 'types_clients_subscribe';
	protected $primaryKey = 'idTypesClientsSubscribe';

	protected $casts = [
		'id_type_client' => 'int',
		'id_subscribe' => 'int',
		'price' => 'float'
	];

	protected $fillable = [
		'id_type_client',
		'id_subscribe',
		'price'
	];

	public function subscribe()
	{
		return $this->belongsTo(\App\Models\Subscribe::class, 'id_subscribe');
	}

	public function types_client()
	{
		return $this->belongsTo(\App\Models\TypesClient::class, 'id_type_client');
	}

	public function details()
	{
		return $this->hasMany(\App\Models\Detail::class, 'id_type_clients_subscribe');
	}
}
