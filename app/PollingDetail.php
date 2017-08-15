<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PollingDetail extends Model
{
    
	protected $table = 'polling_detail';
	
	protected $primaryKey = 'id_detail';
	
	protected $dates = ['created_at', 'updated_at'];
	
}
