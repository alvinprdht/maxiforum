<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Emoticon extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'emoticon';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $primaryKey = 'category_id';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

}
