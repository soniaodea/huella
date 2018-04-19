<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        factory(User::class, 10)->create();

        $user = new User;
        $user->name = 'sonia';
        $user->nif = '00000000A';
        $user->telephone = 123456789;
        $user->email = 'sortizdearri@zubirimanteo.com';
        $user->password = bcrypt('sortizdearri');
        $user->verified = true;
        $user->remember_token = str_random(10);
        $user->save();

    }
}
