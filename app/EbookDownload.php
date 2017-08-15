<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EbookDownload extends Model
{
	
	protected $table = 'ebook_download';
	
	protected $primaryKey = 'id_download';
	
	protected $dates = ['created_at', 'updated_at'];
	
}
