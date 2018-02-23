<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 23 Feb 2018 09:24:59 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Vehicle
 * 
 * @property int $idVehicles
 * @property string $car_number
 * @property string $mark
 * @property string $color
 * @property \Carbon\Carbon $add_date
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $details
 *
 * @package App\Models
 */
class Vehicle extends Eloquent
{
	protected $primaryKey = 'idVehicles';

	protected $dates = [
		'add_date'
	];

	protected $fillable = [
		'car_number',
		'mark',
		'color',
		'add_date'
	];

	public function details()
	{
		return $this->hasMany(\App\Models\Detail::class, 'id_vehicle');
	}
}
