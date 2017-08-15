<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlbumImages extends Model
{
	
	protected $table = 'album_images';
	
	protected $primaryKey = 'id_images';
	
	protected $dates = ['created_at', 'updated_at'];
	
}
