<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBan extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users_ban';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $primaryKey = 'ban_id';

}
