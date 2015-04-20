<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;

use Response;
use Request;
use Auth;
use Hash;

class UserController extends Controller 
{
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
			
			return Response::json([
				'error' => false,
				'user' => [
					'id' => $user->id,
					'email' => $user->email,
					'username' => $user->username
					]
			], 201);
		}
		else
		{
			return $this->getResponseMissingFields();
		}
	}

	public function show()
	{
		$user = Auth::user();
		return Response::json([
			'error' => false,
			'user' => [
				'id' => $user->id,
				'email' => $user->email,
				'username' => $user->username,
				]
			],
			200
		);
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
		
		return Response::json([
			'error' => false,
			'user' => [
				'id' => $user->id,
				'email' => $user->email,
				'username' => $user->username
				]
		], 200);
	}

	public function destroy()
	{
		$user = Auth::user();
		$user->delete();
		
		return Response::json([
			'error' => false,
		], 200);
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
		return Response::json([
			'error' => true,
			'errorCode' => 101,
			'message' => 'Username already exists',
		], 400);
	}
	
	private function getResponseEmailExists()
	{
		return Response::json([
			'error' => true,
			'errorCode' => 102,
			'message' => 'Email already exists',
		], 400);
	}

	private function getResponseMissingFields()
	{
		return Response::json([
			'error' => true,
			'errorCode' => 100,
			'message' => 'Missing fields in request',
		], 400);
	}
}
