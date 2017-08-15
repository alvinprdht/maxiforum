<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Notification extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

	protected $table		= 'notification';
	
	protected $primary_key	= 'id_notification';

}
