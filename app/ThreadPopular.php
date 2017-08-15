<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;

class ThreadPopular extends Model {

	protected $table = 'thread_popular';

	protected $primaryKey = 'popular_id';

}
