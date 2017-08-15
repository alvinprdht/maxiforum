<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
	
	protected $table = 'album';
	
	protected $primaryKey = 'id_album';
	
	protected $dates = ['created_at', 'updated_at'];
	
}
