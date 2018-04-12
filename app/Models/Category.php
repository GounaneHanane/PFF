<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Apr 2018 10:44:28 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Category
 * 
 * @property int $id
 * @property string $label
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Category extends Eloquent
{
	protected $fillable = [
		'label'
	];
}
