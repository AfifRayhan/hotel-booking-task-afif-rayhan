<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoomCategory;
use App\Models\Room;

class RoomCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Premium Deluxe', 'base_price' => 12000],
            ['name' => 'Super Deluxe', 'base_price' => 10000],
            ['name' => 'Standard Deluxe', 'base_price' => 8000],
        ];

        foreach ($categories as $category) {
            $cat = RoomCategory::create($category);
            for ($i = 1; $i <= 3; $i++) {
                Room::create([
                    'room_category_id' => $cat->id,
                    'room_number' => strtoupper(substr($cat->name, 0, 3)) . '-' . $i,
                ]);
            }
        }
    }
}

