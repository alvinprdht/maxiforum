<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostDraftDetail extends Model
{
    //
	protected $table = 'post_draft_detail';
	
	protected $primaryKey = 'id_draft_detail';
	
	protected $dates = ['created_at', 'updated_at'];
}
