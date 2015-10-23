<?php 
namespace App\Http\Controllers\Helpers;

use App\VersionList;

class VersionHelper
{
	public static function getVersion($versionCode)
	{
		return VersionList::getVersionForUser($versionCode)->first();
	}
	
	public static function getLastVersion()
	{
		return VersionList::getLastVersionForUser()->first();
	}
}
