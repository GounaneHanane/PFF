<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 27 Feb 2018 10:31:31 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TypesCustomersSubscribe
 * 
 * @property int $id
 * @property int $id_type_customer
 * @property int $id_subscribe
 * @property float $price
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\TypesSubscribe $types_subscribe
 * @property \App\Models\TypesCustomer $types_customer
 * @property \Illuminate\Database\Eloquent\Collection $details
 *
 * @package App\Models
 */
class TypesCustomersSubscribe extends Eloquent
{
	protected $casts = [
		'id_type_customer' => 'int',
		'id_subscribe' => 'int',
		'price' => 'float'
	];

	protected $fillable = [
		'id_type_customer',
		'id_subscribe',
		'price'
	];

	public function types_subscribe()
	{
		return $this->belongsTo(\App\Models\TypesSubscribe::class, 'id_subscribe');
	}

	public function types_customer()
	{
		return $this->belongsTo(\App\Models\TypesCustomer::class, 'id_type_customer');
	}

	public function details()
	{
		return $this->hasMany(\App\Models\Detail::class, 'id_type_customer_subscribe');
	}
}
