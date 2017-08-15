<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostLanguage extends Model
{
    
	protected $table = 'post_language';
	
	protected $primaryKey = 'id_postlanguage';
	
	protected $dates = ['created_at', 'updated_at'];

}
