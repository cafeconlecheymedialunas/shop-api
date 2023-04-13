<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

use App\Models\Profile;

use App\Models\Order;
use App\Models\Post;

use App\Models\Rating;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
      
       Profile::factory(10)->create();
        
       

 
       
        Post::factory(10)->hasTags(3)->hasCategories(3)->hasComments(2)->create();  
        Order::factory(10)->create()->each(function($order){
            $products = Product::factory(10)->hasTags(3)->hasCategories(3)->hasColors(3)->hasComments(2)->has(Rating::factory()->count(3))->create();
            $order->products()->attach($products->pluck("id"),['quantity' => rand(1,10)]);
        });
 
     
    }
}
