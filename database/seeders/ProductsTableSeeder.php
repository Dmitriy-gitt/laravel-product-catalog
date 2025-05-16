<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Property;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    public function run(): void
    {
        $properties = [
            'Цвет плафона' => ['белый', 'черный', 'красный'],
            'Цвет арматуры' => ['серебро', 'золото', 'черный'],
            'Бренд' => ['Xiaomi', 'Ikea', 'Philips']
        ];

        foreach ($properties as $name => $values) {
            Property::query()->firstOrCreate(['name' => $name]);
        }

        for ($i = 0; $i < 100; $i++) {
            $product = Product::query()->create([
                'name' => 'Товар ' . ($i + 1),
                'price' => rand(100, 10000) / 100,
                'quantity' => rand(1, 100)
            ]);

            foreach ($properties as $name => $values) {
                $property = Property::query()->where('name', $name)->first();
                $product->properties()->attach($property->id, [
                    'value' => $values[array_rand($values)]
                ]);
            }
        }
    }
}
