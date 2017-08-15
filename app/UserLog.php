<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
	
    protected $fillable = [
        'id_user', 'desc', 'old', 'new', 'created_at'
    ];
	
	protected $table = 'user_log';
	
	protected $primaryKey = 'id_userlog';
	
	protected $dates = ['created_at'];
	
}
