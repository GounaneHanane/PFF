<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 27 Feb 2018 10:31:08 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Customer
 * 
 * @property int $id
 * @property string $cin
 * @property string $name
 * @property string $contact
 * @property string $contact_phone
 * @property string $email
 * @property string $city
 * @property string $phone
 * @property int $id_type_customer
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\TypesCustomer $types_customer
 * @property \Illuminate\Database\Eloquent\Collection $accounts
 * @property \Illuminate\Database\Eloquent\Collection $contracts
 *
 * @package App\Models
 */
class Customer extends Eloquent
{
	protected $casts = [
		'id_type_customer' => 'int'
	];

	protected $fillable = [
		'cin',
		'name',
		'contact',
		'contact_phone',
		'email',
		'city',
		'phone',
		'id_type_customer',
        'isActive'
	];

	public function types_customer()
	{
		return $this->belongsTo(\App\Models\TypesCustomer::class, 'id_type_customer');
	}

	public function accounts()
	{
		return $this->hasMany(\App\Models\Account::class, 'id_customer');
	}

	public function contracts()
	{
		return $this->hasMany(\App\Models\Contract::class, 'id_customer');
	}
}
