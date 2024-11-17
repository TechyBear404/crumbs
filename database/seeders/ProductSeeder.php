<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    private function convertPrice($price)
    {
        return (float) str_replace([',', ' €'], ['.', ''], $price);
    }

    public function run(): void
    {
        // First create ingredients
        $ingredients = [
            'Jambon',
            'Fromage',
            'Œuf',
            'Américain préparé',
            'Bacon',
            'Fromage de chèvre',
            'Miel',
            'Thym',
            'Tomates',
            'Roquette',
            'Mozzarella',
            'Parmesan',
            'Brie',
            'Saumon fumé',
            'Oignons frais',
            'Sauce miel-moutarde',
            'Aneth',
            'Crudités',
            'Sauce moutarde',
            'Tomates séchées',
            'Carpaccio de bœuf'
        ];

        foreach ($ingredients as $ingredientName) {
            Ingredient::create(['name' => $ingredientName]);
        }

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
                'categoryId' => $categoryBoissonsFroides->id
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
                'categoryId' => $categoryBoissonsChaud->id
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
                'categoryId' => $categorySandwichesClassiques->id
            ]);
        }

        // For Sandwiches Créatifs
        $categorySandwichesCreatifs = Category::where('name', 'Sandwiches Créatifs')->first();
        $sandwichesCreatifs = [
            [
                'name' => 'CLUB Maison',
                'price' => 4.50,
                'ingredients' => ['Jambon', 'Fromage', 'Crudités', 'Œuf']
            ],
            [
                'name' => 'Le Chèvre',
                'price' => 4.50,
                'ingredients' => ['Fromage de chèvre', 'Bacon', 'Miel', 'Thym']
            ],
            // Add more sandwiches as needed
        ];

        foreach ($sandwichesCreatifs as $sandwich) {
            $product = Product::create([
                'name' => $sandwich['name'],
                'price' => $sandwich['price'],
                'categoryId' => $categorySandwichesCreatifs->id
            ]);

            // Attach ingredients
            $ingredientIds = Ingredient::whereIn('name', $sandwich['ingredients'])
                ->pluck('id');
            $product->ingredients()->attach($ingredientIds);
        }

        // Continue with other categories...
    }
}
