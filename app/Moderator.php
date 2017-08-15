<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Moderator extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'moderator';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $primaryKey = 'moderator_id';

}
