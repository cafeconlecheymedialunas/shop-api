<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\Rating;

use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows_of_principal_models = config("seedersQuantity.principal_model");
        $rows_of_secondary_models = config("seedersQuantity.secondary_model");


        Order::factory($rows_of_principal_models)->create()->each(function($order) use($rows_of_secondary_models){
            $products = Product::factory($rows_of_secondary_models)
                ->hasTags($rows_of_secondary_models)
                ->hasCategories($rows_of_secondary_models )
                ->hasColors($rows_of_secondary_models )
                //->hasComments($rows_of_secondary_models )
                ->has(Rating::factory()->count($rows_of_secondary_models ))
                ->create();
            $order->products()->attach($products->pluck("id"),['quantity' => rand(1,10)]);
        });
    }
}
