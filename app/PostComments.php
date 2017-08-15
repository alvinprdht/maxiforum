<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostComments extends Model
{
	
	protected $table = 'post_comments';
	
	protected $primaryKey = 'id_comments';
	
	protected $dates = ['created_at', 'updated_at'];
	
}
