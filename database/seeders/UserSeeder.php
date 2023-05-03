<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        try{
            $users = (
                [
                    [
                        'name' => 'Admin',
                        'email' => 'admin@example.com',
                        'password' => Hash::make('admin_password'),
                    ],
                    [
                        'name' => 'User',
                        'email' => 'user@example.com',
                        'password' => Hash::make('user_password'),
                    ]
                ]         
            );
            collect($users)->each(function ($user) { User::create($user); });
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return $e->getMessage();
        }
        
    }
}
