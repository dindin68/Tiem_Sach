<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // DB::table('customers')->insert([
        //     'id' => '3',
        //     'name' => 'Đình Đình',
        //     'email' => 'dinwork04@gmail.com',
        //     'password' => bcrypt('12345678'),
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        // DB::table('admins')->insert([
        //     'id' => 'admin1',
        //     'name' => 'Admin',
        //     'email' => 'admin@example.com',
        //     'password' => bcrypt('admin123'),
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        DB::table('categories')->insert([
            ['id' => Str::uuid()->toString(), 'name' => 'Văn học'],
            ['id' => Str::uuid()->toString(), 'name' => 'Khoa học'],
            ['id' => Str::uuid()->toString(), 'name' => 'Thiếu nhi'],
        ]);

        DB::table('books')->insert([
            [
                'id' => Str::uuid()->toString(),
                'title' => 'Dế Mèn Phiêu Lưu Ký',
                'author' => 'Tô Hoài',
                'publisher' => 'NXB Kim Đồng',
                'price' => 10.99,
                'stock' => 100,
                'imported' => 150,
                'sold' => 50,
                'category_id' => DB::table('categories')->where('name', 'Thiếu nhi')->first()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid()->toString(),
                'title' => 'Sapiens',
                'author' => 'Yuval Noah Harari',
                'publisher' => 'NXB Tri Thức',
                'price' => 15.99,
                'stock' => 80,
                'imported' => 100,
                'sold' => 20,
                'category_id' => DB::table('categories')->where('name', 'Khoa học')->first()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}