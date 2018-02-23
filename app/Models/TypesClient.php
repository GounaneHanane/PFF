<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 23 Feb 2018 09:24:59 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TypesClient
 * 
 * @property int $id_types_clients
 * @property string $types_clients
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $clients
 * @property \Illuminate\Database\Eloquent\Collection $subscribes
 *
 * @package App\Models
 */
class TypesClient extends Eloquent
{
	protected $primaryKey = 'id_types_clients';

	protected $fillable = [
		'types_clients'
	];

	public function clients()
	{
		return $this->hasMany(\App\Models\Client::class, 'id_type_client');
	}

	public function subscribes()
	{
		return $this->belongsToMany(\App\Models\Subscribe::class, 'types_clients_subscribe', 'id_type_client', 'id_subscribe')
					->withPivot('idTypesClientsSubscribe', 'price')
					->withTimestamps();
	}
}
