<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PollingAnswer extends Model
{
    
	protected $table = 'polling_answer';
	
	protected $primaryKey = 'id_answer';
	
	protected $dates = ['created_at', 'updated_at'];
	
}
