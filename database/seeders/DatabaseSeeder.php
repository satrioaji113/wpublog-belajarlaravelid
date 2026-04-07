<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([CategorySeeder::class, UserSeeder::class, PostSeeder::class]);// ini digunakan untuk memanggil seeder category yang sudah kita buat sendiri pada /seeder/CategorySeeder

        //dengan kita membuat PostSeeder, seeder yang sudah kita buat bisa kita letakkan di seeder Post, karena isi dari seeder adalah seeder post, setelah itu tinggal  kita panggil PostSeeder pada metode diatas

        //kita bisa menggunakan factory seeder ini persis seperti yang telah kita pelajari pada tinker yaitu bisa menggunakan recycle() dan mengisi recycle() tersebut lebih dari satu factory dengan menggunakan array

        // User::factory()->create([
        //     'name' => 'Satrio Aji',
        //     'username'=>'satrioaji',
        //     'email' => 'satrioaji@gmail.com',
        // ]);
    }
}
