<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $dataUser = [
            [
                'id' => 1,
                'fullname' => 'Admin',
                'avatar' => 'user/no_avatar.jpg',
                'email' => "chan.manet@gmail.com",
                'password' => 'admin123',
                'password_confirmation' => 'admin123',
                'local_fullname' => 'រ័ត្ន អង្គារម៉ាណែត',
                'phone_number' => '+855 123 456 789',
                'role_id' => 1,
                'updated_at' => \Carbon\Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 2,
                'fullname' => 'Sokha Vireak',
                'avatar' => 'user/no_avatar.jpg',
                'email' => "sokha.vireak@gmail.com",
                'password' => 'sokha2023',
                'password_confirmation' => 'sokha2023',
                'local_fullname' => 'សុខា វិរៈ',
                'phone_number' => '+855 987 654 321',
                'role_id' => 2,
                'updated_at' => \Carbon\Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 100,
                'fullname' => 'tola',
                'avatar' => 'user/no_avatar.jpg',
                'email' => "tola@gmail.com",
                'password' => 'tola2023',
                'password_confirmation' => 'tola2023',
                'local_fullname' => 'តុលា',
                'phone_number' => '+855 070984770',
                'role_id' => 3,
                'updated_at' => \Carbon\Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 3,
                'fullname' => 'Leakena Meas',
                'avatar' => 'user/no_avatar.jpg',
                'email' => "leakena.meas@gmail.com",
                'password' => 'leakena789',
                'password_confirmation' => 'leakena789',
                'local_fullname' => 'លក្ខិណា មាស',
                'phone_number' => '+855 456 789 123',
                'role_id' => 3,
                'updated_at' => \Carbon\Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 4,
                'fullname' => 'San Sok',
                'avatar' => 'user/no_avatar.jpg',
                'email' => "chantha.sok@gmail.com",
                'password' => 'chantha123',
                'password_confirmation' => 'chantha123',
                'local_fullname' => 'សុខ',
                'phone_number' => '+855 123 456 789',
                'role_id' => 2,
                'updated_at' => \Carbon\Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 5,
                'fullname' => 'Rathana Keo',
                'avatar' => 'user/no_avatar.jpg',
                'email' => "rathana.keo@yahoo.com",
                'password' => 'rathana456',
                'password_confirmation' => 'rathana456',
                'local_fullname' => 'រតនា កែវ',
                'phone_number' => '+855 987 123 456',
                'role_id' => 2,
                'updated_at' => \Carbon\Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 6,
                'fullname' => 'Sophea Lim',
                'avatar' => 'user/no_avatar.jpg',
                'email' => "sophea.lim@outlook.com",
                'password' => 'sophea2024',
                'password_confirmation' => 'sophea2024',
                'local_fullname' => 'សុភា លឹម',
                'phone_number' => '+855 654 321 987',
                'role_id' => 3,
                'updated_at' => \Carbon\Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 7,
                'fullname' => 'Vannak Pheng',
                'avatar' => 'user/no_avatar.jpg',
                'email' => "vannak.pheng@gmail.com",
                'password' => 'vannak999',
                'password_confirmation' => 'vannak999',
                'local_fullname' => 'វណ្ណៈ ភេង',
                'phone_number' => '+855 789 456 123',
                'role_id' => 3,
                'updated_at' => \Carbon\Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 8,
                'fullname' => 'Maly Chhim',
                'avatar' => 'user/no_avatar.jpg',
                'email' => "maly.chhim@hotmail.com",
                'password' => 'maly4321',
                'password_confirmation' => 'maly4321',
                'local_fullname' => 'ម៉ាលី ឈឹម',
                'phone_number' => '+855 321 654 987',
                'role_id' => 3,
                'updated_at' => \Carbon\Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 9,
                'fullname' => 'Piseth Heng',
                'avatar' => 'user/no_avatar.jpg',
                'email' => "piseth.heng@gmail.com",
                'password' => 'piseth007',
                'password_confirmation' => 'piseth007',
                'local_fullname' => 'ពិសិដ្ឋ ហេង',
                'phone_number' => '+855 147 258 369',
                'role_id' => 3,
                'updated_at' => \Carbon\Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 10,
                'fullname' => 'Sreypov Nguon',
                'avatar' => 'user/no_avatar.jpg',
                'email' => "sreypov.nguon@gmail.com",
                'password' => 'sreypov555',
                'password_confirmation' => 'sreypov555',
                'local_fullname' => 'ស្រីពៅ ងួន',
                'phone_number' => '+855 963 852 741',
                'role_id' => 2,
                'updated_at' => \Carbon\Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 11,
                'fullname' => 'Dara Thun',
                'avatar' => 'user/no_avatar.jpg',
                'email' => "dara.thun@yahoo.com",
                'password' => 'dara2025',
                'password_confirmation' => 'dara2025',
                'local_fullname' => 'ដារ៉ា ធន',
                'phone_number' => '+855 852 741 963',
                'role_id' => 2,
                'updated_at' => \Carbon\Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 12,
                'fullname' => 'Nita Som',
                'avatar' => 'user/no_avatar.jpg',
                'email' => "nita.som@outlook.com",
                'password' => 'nita789',
                'password_confirmation' => 'nita789',
                'local_fullname' => 'នីតា សុំ',
                'phone_number' => '+855 369 147 258',
                'role_id' => 3,
                'updated_at' => \Carbon\Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 13,
                'fullname' => 'Ravy Oum',
                'avatar' => 'user/no_avatar.jpg',
                'email' => "ravy.oum@gmail.com",
                'password' => 'ravy101',
                'password_confirmation' => 'ravy101',
                'local_fullname' => 'រ៉ាវី អុំ',
                'phone_number' => '+855 741 963 852',
                'role_id' => 3,
                'updated_at' => \Carbon\Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 14,
                'fullname' => 'Ravy Oum',
                'avatar' => 'user/no_avatar.jpg',
                'email' => "ravy.ou@gmail.com",
                'password' => 'ravy101',
                'password_confirmation' => 'ravy101',
                'local_fullname' => 'រ៉ាវី អុំ',
                'phone_number' => '+855 741 963 852',
                'role_id' => 3,
                'updated_at' => \Carbon\Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 15,
                'fullname' => 'Ravy Oum',
                'avatar' => 'user/no_avatar.jpg',
                'email' => "riva.ou@gmail.com",
                'password' => 'ravy101',
                'password_confirmation' => 'ravy101',
                'local_fullname' => 'រ៉ាវី អុំ',
                'phone_number' => '+855 741 963 852',
                'role_id' => 3,
                'updated_at' => \Carbon\Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 16,
                'fullname' => 'Ravy Oum',
                'avatar' => 'user/no_avatar.jpg',
                'email' => "rivy.ou@gmail.com",
                'password' => 'ravy101',
                'password_confirmation' => 'ravy101',
                'local_fullname' => 'រ៉ាវី អុំ',
                'phone_number' => '+855 741 963 852',
                'role_id' => 3,
                'updated_at' => \Carbon\Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
            ],
        ];

        // // Generate IDs 26 - 35
        // for ($i = 26; $i <= 35; $i++) {
        //     $dataUser[] = [
        //         'id' => $i,
        //         'fullname' => "User $i",
        //         'avatar' => 'user/no_avatar.jpg',
        //         'email' => "user$i@example.com",
        //         'password' => bcrypt("password$i"),
        //         'local_fullname' => "អ្នកប្រើ $i",
        //         'phone_number' => '+855 999 888 ' . ($i - 25),
        //         'role_id' => ($i % 2 == 0) ? 2 : 3, // Alternating roles
        //         'updated_at' => \Carbon\Carbon::now(),
        //         'created_at' => \Carbon\Carbon::now(),
        //     ];
        // }

        foreach ($dataUser as $data) {
            $user = new User();
            $user->fullname = $data['fullname'];
            $user->avatar = $data['avatar'];
            $user->local_fullname = $data['local_fullname'];
            $user->phone_number = $data['phone_number'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->role_id = $data['role_id'];
            $user->save();
        }

    }
}
