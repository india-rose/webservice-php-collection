<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\ResponseHelper;
use App\User;

use Response;
use Request;
use Auth;
use Hash;

class UserController extends Controller 
{
	const ERROR_CODE_MISSING_FIELDS = 100;
	const ERROR_CODE_USERNAME_EXISTS = 101;
	const ERROR_CODE_EMAIL_EXISTS = 102;
	
	public function store()
	{
		if(Request::has('username') && Request::has('email') && Request::has('password'))
		{
			if($this->emailExists(Request::input('email')))
			{
				return $this->getResponseEmailExists();
			}
			
			if($this->usernameExists(Request::input('username')))
			{
				return $this->getResponseUsernameExists();
			}
			
			$user = User::create([
				'username' => Request::input('username'), 
				'password' => Hash::make(Request::input('password')), 
				'email' => Request::input('email')
			]);
			
			return ResponseHelper::created($user);
		}
		else
		{
			return $this->getResponseMissingFields();
		}
	}

	public function show()
	{
		$user = Auth::user();
		return ResponseHelper::processed($user);
	}

	public function update()
	{
		$user = Auth::user();
		if(Request::has('username'))
		{
			if($this->usernameExists(Request::input('username')))
			{
				return $this->getResponseUsernameExists();
			}
		
			$user->username = Request::input('username');
		}
		if(Request::has('email'))
		{
			if($this->emailExists(Request::input('email')))
			{
				return $this->getResponseEmailExists();
			}
		
			$user->email = Request::input('email');
		}
		if(Request::has('password'))
		{
			$user->password = Hash::make(Request::input('password'));
		}
		$user->save();
		
		return ResponseHelper::processed($user);
	}

	public function destroy()
	{
		$user = Auth::user();
		$user->delete();
		
		return ResponseHelper::processed(null);
	}

	private function usernameExists($username)
	{
		if(User::where('username', '=', $username)->first() != null)
		{
			return true;
		}
		return false;
	}
	
	private function emailExists($email)
	{
		if(User::where('email', '=', $email)->first() != null)
		{
			return true;
		}
		return false;
	}

	private function getResponseUsernameExists()
	{
		return ResponseHelper::error(self::ERROR_CODE_USERNAME_EXISTS, 'Username already exists');
	}
	
	private function getResponseEmailExists()
	{
		return ResponseHelper::error(self::ERROR_CODE_EMAIL_EXISTS, 'Email already exists');
	}

	private function getResponseMissingFields()
	{
		return ResponseHelper::error(self::ERROR_CODE_MISSING_FIELDS, 'Missing fields in request');
	}
}
