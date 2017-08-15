<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Visitor extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

	protected $table	= 'statistic_visitor';

}
