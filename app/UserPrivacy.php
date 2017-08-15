<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPrivacy extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users_privacy';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $primaryKey = 'privacy_id';

}
