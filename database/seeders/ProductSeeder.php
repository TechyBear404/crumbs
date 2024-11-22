<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Create categories
        $categories = [
            'Boissons froides',
            'Boissons chaudes',
            'Sandwiches Classiques',
            'Sandwiches Créatifs',
            'Paninis',
            'Cornets de Pâtes'
        ];

        foreach ($categories as $categoryName) {
            Category::create(['name' => $categoryName]);
        }

        // Boissons froides
        $categoryBoissonsFroides = Category::where('name', 'Boissons froides')->first();
        $boissonsFroides = [
            ['name' => 'Coca 33 cl', 'price' => 2.00],
            ['name' => 'Coca Light 33 cl', 'price' => 2.00],
            // ...add all cold drinks here...
        ];

        foreach ($boissonsFroides as $boisson) {
            Product::create([
                'name' => $boisson['name'],
                'price' => $boisson['price'],
                'catid' => $categoryBoissonsFroides->id
            ]);
        }

        // Boissons chaudes
        $categoryBoissonsChaud = Category::where('name', 'Boissons chaudes')->first();
        $boissonsChaud = [
            ['name' => 'Café', 'price' => 2.00],
            ['name' => 'Thé au choix', 'price' => 2.00],
            // ...add all hot drinks here...
        ];

        foreach ($boissonsChaud as $boisson) {
            Product::create([
                'name' => $boisson['name'],
                'price' => $boisson['price'],
                'catid' => $categoryBoissonsChaud->id
            ]);
        }

        // Sandwiches Classiques
        $categorySandwichesClassiques = Category::where('name', 'Sandwiches Classiques')->first();
        $sandwichesClassiques = [
            ['name' => 'Jambon &/ou fromage', 'price_normal' => 3.20, 'price_grand' => 4.00],
            ['name' => 'Bacon', 'price_normal' => 3.90, 'price_grand' => 4.70],
            // ...add all classic sandwiches here...
        ];

        foreach ($sandwichesClassiques as $sandwich) {
            Product::create([
                'name' => $sandwich['name'],
                'price_normal' => $sandwich['price_normal'],
                'price_grand' => $sandwich['price_grand'],
                'catid' => $categorySandwichesClassiques->id
            ]);
        }

        // Continue with other categories...
    }
}
