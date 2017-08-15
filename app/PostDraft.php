<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostDraft extends Model
{
    //
	protected $table = 'post_draft';
	
	protected $primaryKey = 'id_draft';
	
	protected $dates = ['created_at', 'updated_at'];
	
	
}
