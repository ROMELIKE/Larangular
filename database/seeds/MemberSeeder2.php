<?php

use Illuminate\Database\Seeder;

class MemberSeeder2 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('member')->insert(
            [
                [
                    'name' => 'habino',
                    'email' => 'rome@gmail.com',
                    'status' => '1',
                    'age' => 20,
                    'avatar' => 'user.png',
                    'address' => 'hanoi',
                    'created_at' => date('y-m-d H:i:s'),
                ],
                [
                    'name' => 'buiatuan',
                    'email' => 'rome@gmail.com',
                    'status' => '1',
                    'age' => 20,
                    'avatar' => 'user.png',
                    'address' => 'hanoi',
                    'created_at' => date('y-m-d H:i:s'),
                ],
                [
                    'name' => 'moydyli',
                    'email' => 'rome@gmail.com',
                    'status' => '1',
                    'age' => 20,
                    'avatar' => 'user.png',
                    'address' => 'hanoi',
                    'created_at' => date('y-m-d H:i:s'),
                ],
                [
                    'name' => 'conghanh',
                    'email' => 'rome@gmail.com',
                    'status' => '1',
                    'age' => 20,
                    'avatar' => 'user.png',
                    'address' => 'hanoi',
                    'created_at' => date('y-m-d H:i:s'),
                ],
                [
                    'name' => 'keodinhchuot',
                    'email' => 'rome@gmail.com',
                    'status' => '1',
                    'age' => 20,
                    'avatar' => 'user.png',
                    'address' => 'hanoi',
                    'created_at' => date('y-m-d H:i:s'),
                ],
                [
                    'name' => 'hungbanhbao',
                    'email' => 'rome@gmail.com',
                    'status' => '1',
                    'avatar' => 'user.png',
                    'address' => 'hanoi',
                    'age' => 20,
                    'created_at' => date('y-m-d H:i:s'),
                ],
                [
                    'name' => 'bowman',
                    'email' => 'rome@gmail.com',
                    'status' => '1',
                    'age' => 20,
                    'avatar' => 'user.png',
                    'address' => 'hanoi',
                    'created_at' => date('y-m-d H:i:s'),
                ],
                [
                    'name' => 'dux',
                    'email' => 'rome@gmail.com',
                    'status' => '1',
                    'age' => 20,
                    'avatar' => 'user.png',
                    'address' => 'hanoi',
                    'created_at' => date('y-m-d H:i:s'),
                ],
                [
                    'name' => 'minhmapmap',
                    'email' => 'rome@gmail.com',
                    'status' => '1',
                    'age' => 20,
                    'avatar' => 'user.png',
                    'address' => 'hanoi',
                    'created_at' => date('y-m-d H:i:s'),
                ],
            ]
        );
    }
}
