<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Apr 2018 10:44:28 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Contract
 * 
 * @property int $id
 * @property \Carbon\Carbon $start_contract
 * @property \Carbon\Carbon $end_contract
 * @property int $id_customer
 * @property string $urlContract
 * @property int $nbAvance
 * @property int $nbSimple
 * @property float $priceSimple
 * @property float $priceAvance
 * @property float $defaultSimple
 * @property float $defaultAvance
 * @property float $price
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property bool $isActive
 *
 * @package App\Models
 */
class Contract extends Eloquent
{
	protected $casts = [
		'id_customer' => 'int',

        'id' => 'varchar',

		'nbAvance' => 'int',
		'nbSimple' => 'int',
		'priceSimple' => 'float',
		'priceAvance' => 'float',
		'defaultSimple' => 'float',
		'defaultAvance' => 'float',
		'price' => 'float',
		'isActive' => 'bool'

	];

	protected $dates = [
		'start_contract',
		'end_contract'
	];

	protected $fillable = [

        'id',
		'id_customer',

		'start_contract',
		'end_contract',
		'id_customer',
		'urlContract',
		'nbAvance',
		'nbSimple',
		'priceSimple',
		'priceAvance',
		'defaultSimple',
		'defaultAvance',
		'price',
		'isActive'
	];


	public function customer()
	{
		return $this->belongsTo(\App\Models\Customer::class, 'id_customer');
	}

	public function renouvelement()
	{
		return $this->hasMany(\App\Models\Detail::class, 'id_contract');
	}

}
