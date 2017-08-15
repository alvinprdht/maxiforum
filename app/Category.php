<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	
	protected $table = 'post_category';
	
	protected $primaryKey = 'id_category';
	
	protected $dates = ['created_at', 'updated_at'];
	
}
