<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Apr 2018 10:44:28 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Customer
 * 
 * @property int $id
 * @property string $name
 * @property string $contact
 * @property string $type
 * @property string $phone_number
 * @property string $mail
 * @property string $city
 * @property string $departement
 * @property int $id_type_customer
 * @property string $adress
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Customer extends Eloquent
{
	protected $casts = [
		'id_type_customer' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'name',
		'contact',
		'type',
		'phone_number',
		'mail',
		'city',
		'departement',
		'id_type_customer',
		'adress',
		'user_id'
	];
}
