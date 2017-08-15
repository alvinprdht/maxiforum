<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ThreadReply extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'thread_reply';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $primaryKey = 'threadreply_id';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

}
