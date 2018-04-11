<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Apr 2018 10:44:28 +0000.
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
 * @property float $price
 * @property bool $offer
 * @property \Carbon\Carbon $AddingDate
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property bool $isActive
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
		'offer' => 'bool',
		'isActive' => 'bool'
	];

	protected $dates = [
		'AddingDate'
	];

	protected $fillable = [
		'id_contract',
		'id_vehicle',
		'id_type_customer_subscribe',
		'price',
		'offer',
		'AddingDate',
		'isActive'
	];
}
