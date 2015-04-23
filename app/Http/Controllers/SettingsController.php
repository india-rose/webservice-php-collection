<?php 
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Helpers\VersionHelper;
use App\Http\Controllers\Helpers\ResponseHelper;

use App\Setting;
use App\VersionList;

use Request;

class SettingsController extends Controller {

	const ERROR_CODE_MISSING_FIELDS = 200;
	const ERROR_CODE_DONT_EXISTS = 201;
	const ERROR_CODE_VERSION_DONT_EXISTS = 202;

	public function store()
	{
		if(!Request::has('version') || !Request::has('content'))
		{
			return $this->getResponseMissingFields();
		}
		
		// check if version exists
		$version = VersionHelper::getVersion(Request::input('version'));
		
		if($version == null)
		{
			return $this->getResponseVersionDontExists();
		}
		
		// store content to a new settings
		$settings = Settings::create([
			'user_id' => Auth::user()->id,
			'version' => $version->version,
			'content' => Request::input('content'),
		]);
		
		return ResponseHelper::created($settings);
	}
	
	public function getLast()
	{
		$version = VersionHelper::getLastVersion();
		
		if($version == null)
		{
			return $this->getResponseVersionDontExists();
		}
		
		$settings = $this->getSettingsForVersion($version);
		
		return ResponseHelper::processed($settings);
	}
	
	public function get($versionCode)
	{
		$version = VersionHelper::getVersion($versionCode);
		
		if($version == null)
		{
			return $this->getResponseVersionDontExists();
		}
		
		$settings = $this->getSettingsForVersion($version);
		
		return ResponseHelper::processed($settings);
	}
	
	private function getSettingsForVersion($version)
	{
		return Setting::ofUser()->forVersion($version)->first();
	}
	
	private function getResponseMissingFields()
	{
		return ResponseHelper::error(self::ERROR_CODE_MISSING_FIELDS, 'Missing fields in request');
	}
	
	private function getResponseDontExists()
	{
		return ResponseHelper::notFound(self::ERROR_CODE_DONT_EXISTS, 'Settings does not exists yet');
	}
	
	private function getResponseVersionDontExists()
	{
		return ResponseHelper::notFound(self::ERROR_CODE_VERSION_DONT_EXISTS, 'This version does not exists');
	}
}
