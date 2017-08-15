<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'email', 'password',
    ];
	
	protected $table = 'user';
	
	protected $primaryKey = 'id_user';
	
	protected $dates = ['created_at', 'updated_at'];
	
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
	
	public function role()
	{
		return $this->role;
	}
	
	public function isAdmin()
	{
		if($this->role == '3')
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function isEditor()
	{
		if($this->role == '2')
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function isContributor()
	{
		if($this->role == '1')
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
}
