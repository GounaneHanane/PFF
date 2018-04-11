<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Apr 2018 10:44:28 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class DetailsIntervention
 * 
 * @property int $id
 * @property string $type
 * @property int $id_vehicule
 * @property int $imei_boitier
 * @property int $imei_carte
 * @property int $id_intervention
 * @property int $kilometrage
 * @property string $remarque
 * @property string $box_costumer
 * @property string $sim_costumer
 * @property string $status
 *
 * @package App\Models
 */
class DetailsIntervention extends Eloquent
{
	protected $table = 'details_intervention';
	public $timestamps = false;

	protected $casts = [
		'id_vehicule' => 'int',
		'imei_boitier' => 'int',
		'imei_carte' => 'int',
		'id_intervention' => 'int',
		'kilometrage' => 'int'
	];

	protected $fillable = [
		'type',
		'id_vehicule',
		'imei_boitier',
		'imei_carte',
		'id_intervention',
		'kilometrage',
		'remarque',
		'box_costumer',
		'sim_costumer',
		'status'
	];
}
