<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'subscribe';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $primaryKey = 'subscribe_id';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

}
