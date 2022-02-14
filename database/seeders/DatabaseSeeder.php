<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Counter;
use App\Models\Service;
use Prophecy\Call\Call;
use Illuminate\Database\Seeder;
use Database\Seeders\ServiceSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create(['email' => 'admin@example.com', 'role' => 'admin']);
        User::factory()->create(['email' => 'officer@example.com', 'role' => 'officer']);
        User::factory(10)->create();
        $servicesList = ['Peminjaman Buku', 'Pengembalian Buku', 'Sumbangan Buku', 'Lain - lain'];
        $ServicesListCode = ['A.', 'B.', 'C.', 'D.'];
        for ($i=0; $i < 4; $i++) { 
            Service::factory()->create([
                'name' => $servicesList[$i],
                'code' => $ServicesListCode[$i],
            ]);
        }
        Counter::factory(5)->create();
    }
}