<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostVideos extends Model
{
	
	protected $table = 'post_videos';
	
	protected $primaryKey = 'id_videos';
	
	protected $dates = ['created_at', 'updated_at'];
	
}
