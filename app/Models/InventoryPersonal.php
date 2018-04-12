<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Apr 2018 10:44:28 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class InventoryPersonal
 * 
 * @property int $id
 * @property int $personal_id
 * @property int $product_id
 * @property int $user_id
 * @property string $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class InventoryPersonal extends Eloquent
{
	protected $casts = [
		'personal_id' => 'int',
		'product_id' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'personal_id',
		'product_id',
		'user_id',
		'status'
	];
}
