<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsletterParticipant extends Model
{

    protected $table = 'newsletter_participant';

    protected $primaryKey = 'id_participant';

    protected $dates = ['created_at', 'updated_at'];

}
