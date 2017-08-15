<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    
	protected $table = 'post';
	
	protected $primaryKey = 'id_post';
	
	protected $dates = ['created_at', 'updated_at'];
	
}
