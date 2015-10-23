<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Setting extends Model 
{
	protected $table = 'settings';
	
	protected $guarded = ['id'];
	
	public function scopeOfUser($query)
	{
		return $query->where('user_id', '=', Auth::user()->id);
	}
	
	public function scopeForVersion($query, $version)
	{
		return $query->where('version', '=', $version->version)->orderBy('version', 'DESC');
	}
	
	public function toJsonArray()
	{
		return [
			'version' => $this->version,
			'content' => $this->content,
		];
	}
}
