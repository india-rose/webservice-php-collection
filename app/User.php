<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model implements AuthenticatableContract
{
	use Authenticatable;
	
	protected $table = 'users';
	
	protected $guarded = ['id'];
	
	public function toJsonArray()
	{
		return [
			'username' => $this->username,
			'email' => $this->email,
		];
	}
}
