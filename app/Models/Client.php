<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 23 Feb 2018 09:24:59 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Client
 * 
 * @property int $idClients
 * @property string $cin
 * @property string $name
 * @property string $contact
 * @property string $email
 * @property string $city
 * @property string $phone
 * @property int $id_type_client
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\TypesClient $types_client
 * @property \Illuminate\Database\Eloquent\Collection $accounts
 * @property \Illuminate\Database\Eloquent\Collection $contracts
 *
 * @package App\Models
 */
class Client extends Eloquent
{
	protected $primaryKey = 'idClients';

	protected $casts = [
		'id_type_client' => 'int'
	];

	protected $fillable = [
		'cin',
		'name',
		'contact',
		'email',
		'city',
		'phone',
		'id_type_client'
	];

	public function types_client()
	{
		return $this->belongsTo(\App\Models\TypesClient::class, 'id_type_client');
	}

	public function accounts()
	{
		return $this->hasMany(\App\Models\Account::class, 'id_client');
	}

	public function contracts()
	{
		return $this->hasMany(\App\Models\Contract::class, 'id_client');
	}
}
