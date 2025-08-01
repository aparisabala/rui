<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\DynArticle;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Webpatser\Uuid\Uuid;
use DB;
use App\Models\DynArticlesSub;
use App\Models\DynComponents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('globusers')->insert([
            'uuid' => (string) Uuid::generate(4),
            'name' => "Just Tech Admin",
            'mobile_number' => "017XXXXXXXXX",
            'email' => "admin@admin.com",
            'password' => Hash::make('123456789'),
            'user_access' => json_encode(['SA']),
            'created_at' =>  Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' =>  Carbon::now()->format('Y-m-d H:i:s'),

        ]);
        DB::table('app_data')->insert([
            'created_at' =>  Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' =>  Carbon::now()->format('Y-m-d H:i:s'),

        ]);
    }
}
