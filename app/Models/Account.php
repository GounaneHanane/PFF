<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 27 Feb 2018 10:31:31 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Account
 * 
 * @property int $idAccount
 * @property string $login
 * @property int $id_customer
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\Customer $customer
 *
 * @package App\Models
 */
class Account extends Eloquent
{
	protected $primaryKey = 'idAccount';

	protected $casts = [
		'id_customer' => 'int'
	];

	protected $fillable = [
		'login',
		'id_customer'
	];

	public function customer()
	{
		return $this->belongsTo(\App\Models\Customer::class, 'id_customer');
	}
}
