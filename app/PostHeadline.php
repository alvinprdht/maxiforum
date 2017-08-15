<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostHeadline extends Model
{
    
	protected $table = 'post_headline';
	
	protected $primaryKey = 'id_headline';
	
	protected $dates = ['created_at', 'updated_at'];

}
