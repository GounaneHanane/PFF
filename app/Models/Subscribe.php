<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 23 Feb 2018 09:24:59 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Subscribe
 * 
 * @property int $idSubscribe
 * @property string $type_subscribe
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $types_clients
 *
 * @package App\Models
 */
class Subscribe extends Eloquent
{
	protected $table = 'subscribe';
	protected $primaryKey = 'idSubscribe';

	protected $fillable = [
		'type_subscribe'
	];

	public function types_clients()
	{
		return $this->belongsToMany(\App\Models\TypesClient::class, 'types_clients_subscribe', 'id_subscribe', 'id_type_client')
					->withPivot('idTypesClientsSubscribe', 'price')
					->withTimestamps();
	}
}
