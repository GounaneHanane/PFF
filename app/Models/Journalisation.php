<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Apr 2018 10:44:28 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Journalisation
 * 
 * @property int $id
 * @property string $action
 * @property \Carbon\Carbon $created_at
 * @property string $utilisateur
 * @property \Carbon\Carbon $update_at
 *
 * @package App\Models
 */
class Journalisation extends Eloquent
{
	protected $table = 'journalisation';
	public $timestamps = false;

	protected $dates = [
		'update_at'
	];

	protected $fillable = [
		'action',
		'utilisateur',
		'update_at'
	];
}
