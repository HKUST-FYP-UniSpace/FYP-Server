<?php

use Illuminate\Database\Seeder;

class UserTempSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
          [
            'username'=>'testUser1',
            'name'=>'User One',
            'email'=>'testUser1@connect.ust.hk',
            'password'=>'xxx1',
            'token'=>'abc001',
            'is_verified'=>1,
            'is_deleted'=>0
          ],
          [
            'username'=>'testUser2',
            'name'=>'User Two',
            'email'=>'testUser2@connect.ust.hk',
            'password'=>'xxx2',
            'token'=>'abc002',
            'is_verified'=>1,
            'is_deleted'=>0
          ],
          [
            'username'=>'testUser3',
            'name'=>'User Three',
            'email'=>'testUser3@connect.ust.hk',
            'password'=>'xxx3',
            'token'=>'abc003',
            'is_verified'=>1,
            'is_deleted'=>0
          ],
          [
            'username'=>'testUser4',
            'name'=>'User Four',
            'email'=>'testUser4@connect.ust.hk',
            'password'=>'xxx4',
            'token'=>'abc004',
            'is_verified'=>0,
            'is_deleted'=>0
          ],
        ]);
    }
}
