<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'     => 'Leandro Facim',
            'email'    => 'leandro.facim@hotmail.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
