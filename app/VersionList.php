<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class VersionList extends Model 
{
	protected $table = 'versionlist';
	
	protected $guarded = ['id'];
}
