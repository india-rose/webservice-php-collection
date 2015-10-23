<?php 
namespace App\Http\Controllers\Helpers;
use Response;
class ResponseHelper
{
	public static function processed($resource, $resultCode = 200)
	{
		return self::correctResponse($resource, $resultCode);
	}
	
	public static function created($resource, $resultCode = 200)
	{
		return self::correctResponse($resource, $resultCode);
	}
	
	public static function error($errorCode, $errorMessage, $resultCode = 400)
	{
		return self::incorrectResponse($errorCode, $errorMessage, $resultCode);
	}
	
	public static function notFound($errorCode, $errorMessage, $resultCode = 404)
	{
		return self::incorrectResponse($errorCode, $errorMessage, $resultCode);
	}
	
	private static function correctResponse($resource, $resultCode)
	{
		$content = null;
		if($resource != null)
		{
			$content = $resource->toJsonArray();
		}
		
		return Response::json([
			'error' => false,
			'resource' => $content,
		], $resultCode);
	}
	
	private static function incorrectResponse($errorCode, $errorMessage, $resultCode)
	{
		return Response::json([
			'error' => true,
			'errorCode' => $errorCode,
			'message' => $errorMessage,
		], $resultCode);
	}
}
