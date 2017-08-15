<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMessage extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users_message';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $primaryKey = 'message_id';

}
