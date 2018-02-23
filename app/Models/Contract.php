<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 23 Feb 2018 09:24:59 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Contract
 * 
 * @property int $idContract
 * @property int $id_client
 * @property \Carbon\Carbon $start_date
 * @property \Carbon\Carbon $end_date
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\Client $client
 * @property \Illuminate\Database\Eloquent\Collection $details
 *
 * @package App\Models
 */
class Contract extends Eloquent
{
	protected $table = 'contract';
	protected $primaryKey = 'idContract';

	protected $casts = [
		'id_client' => 'int'
	];

	protected $dates = [
		'start_date',
		'end_date'
	];

	protected $fillable = [
		'id_client',
		'start_date',
		'end_date'
	];

	public function client()
	{
		return $this->belongsTo(\App\Models\Client::class, 'id_client');
	}

	public function details()
	{
		return $this->hasMany(\App\Models\Detail::class, 'id_contract');
	}
}
