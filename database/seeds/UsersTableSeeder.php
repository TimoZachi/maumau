<?php

use Illuminate\Database\Seeder;
use MauMau\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Administrador Master',
            'email' => 'admin@email.com',
            'password' => bcrypt('123456')
        ]);
	    $user->admin = 1;
	    $user->save();
    }
}
