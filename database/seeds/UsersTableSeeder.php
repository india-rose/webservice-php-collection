<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder {
 
  public function run()
  {
      DB::table('users')->delete();
 
      User::create(array(
          'username' => 'julien',
          'password' => Hash::make('capucin'),
		  'email' => 'mialon.julien@gmail.com'
      ));
 
      User::create(array(
          'username' => 'indiarose',
          'password' => Hash::make('imaginecup'),
		  'email' => 'equipe.indiarose@gmail.com'
      ));
  }
 
}


