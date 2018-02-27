<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 27 Feb 2018 10:31:31 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TypesCustomer
 * 
 * @property int $id
 * @property string $type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $customers
 * @property \Illuminate\Database\Eloquent\Collection $types_customers_subscribes
 *
 * @package App\Models
 */
class TypesCustomer extends Eloquent
{
	protected $fillable = [
		'type'
	];

	public function customers()
	{
		return $this->hasMany(\App\Models\Customer::class, 'id_type_customer');
	}

	public function types_customers_subscribes()
	{
		return $this->hasMany(\App\Models\TypesCustomersSubscribe::class, 'id_type_customer');
	}
}
