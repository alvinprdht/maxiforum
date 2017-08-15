<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Polling extends Model
{
	
	protected $table = 'polling';
	
	protected $primaryKey = 'id_polling';
	
	protected $dates = ['created_at', 'updated_at'];
	
}
