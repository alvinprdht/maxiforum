<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EbookModule extends Model
{
    
	protected $table = 'ebook_module';
	
	protected $primaryKey = 'id_ebook';
	
	protected $dates = ['created_at', 'updated_at'];
	
}
