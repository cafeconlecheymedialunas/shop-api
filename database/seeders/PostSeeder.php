<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Post;
class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows_of_principal_models = config("seedersQuantity.principal_model");
        $rows_of_secondary_models = config("seedersQuantity.secondary_model");
        Post::factory($rows_of_principal_models)
            ->hasTags($rows_of_secondary_models)
            ->hasCategories($rows_of_secondary_models)
            ->hasComments($rows_of_principal_models)
            ->create();  
    }
}
