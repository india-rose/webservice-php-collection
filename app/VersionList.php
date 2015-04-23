<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class VersionList extends Model 
{
	protected $table = 'versionlist';
	
	protected $guarded = ['id'];
	
	public function scopeOfUser($query)
	{
		return $query->where('user_id', '=', Auth::user()->id);
	}

	public function scopeOrderDesc($query)
	{
		return $query->orderBy('version', 'DESC');
	}
	
	public function scopeFindByNumber($query, $versionCode)
	{
		return $query->where('version', '=', $versionCode);
	}
	
	public function scopeGetVersionForUser($query, $versionCode)
	{
		return $query->ofUser()->findByNumber($versionCode);
	}
	
	public function scopeGetLastVersionForUser($query)
	{
		return $query->ofUser()->orderDesc();
	}
}
