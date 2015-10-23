<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Indiagram extends Model 
{
	protected $table = 'indiagrams';
	
	protected $guarded = ['id'];
	
	public function scopeOfUser($query)
	{
		return $query->where('user_id', '=', Auth::user()->id);
	}
}
