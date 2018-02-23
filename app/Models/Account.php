<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 23 Feb 2018 09:24:59 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Account
 * 
 * @property int $idAccount
 * @property string $login
 * @property int $id_client
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\Client $client
 *
 * @package App\Models
 */
class Account extends Eloquent
{
	protected $primaryKey = 'idAccount';

	protected $casts = [
		'id_client' => 'int'
	];

	protected $fillable = [
		'login',
		'id_client'
	];

	public function client()
	{
		return $this->belongsTo(\App\Models\Client::class, 'id_client');
	}
}
