<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        User::create([
            'name' => 'admin',
            'email' =>'tienntm@onetech.vn',
            'password' => bcrypt('12345678'),
            'role_id' => 1
        ]);
    }
}
