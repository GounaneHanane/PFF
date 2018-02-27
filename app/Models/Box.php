<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 27 Feb 2018 10:31:31 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Box
 * 
 * @property int $id
 * @property string $reference
 * @property string $type_box
 * @property string $numero_operetor
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $details
 *
 * @package App\Models
 */
class Box extends Eloquent
{
	protected $fillable = [
		'reference',
		'type_box',
		'numero_operetor'
	];

	public function details()
	{
		return $this->hasMany(\App\Models\Detail::class, 'id_boxe');
	}
}
