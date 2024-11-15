<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Product;
use App\Models\ProductIngredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('view', Product::class);

        $products = Product::all();
        // dd($products);
        return view('product.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Product::class);

        $categories = Category::orderBy('name')->get();
        $ingredients = Ingredient::orderBy('name')->get();
        return view('product.create', ['categories' => $categories, 'ingredients' => $ingredients]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Product::class);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:App\Models\Product,name',
            'description' => 'nullable | string | max:255',
            'catid' => 'required | integer',
            'ingredientsList' => 'required | array',
            'status' => 'required|in:available,unavailable',
        ]);


        $product = Product::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'catid' => $validatedData['catid'],
            'status' => $validatedData['status'],
        ]);

        foreach ($validatedData['ingredientsList'] as $ingrId) {
            ProductIngredient::create([
                'ingrId' => $ingrId,
                'prodId' => $product->id,
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Gate::authorize('view', Product::class);

        $product = Product::findOrFail($id);
        return view('product.show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Gate::authorize('update', Product::class);

        $product = Product::findOrFail($id);
        $categories = Category::orderBy('name')->get();
        $ingredients = Ingredient::orderBy('name')->get();

        return view('product.edit', ['product' => $product, 'categories' => $categories, 'ingredients' => $ingredients]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Gate::authorize('update', Product::class);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable | string | max:255',
            'catid' => 'required | integer',
            'ingredientsList' => 'required | array',
            'status' => 'required|in:available,unavailable',
        ]);

        $product = Product::findOrFail($id);

        $product->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'catid' => $validatedData['catid'],
            'status' => $validatedData['status'],
        ]);

        ProductIngredient::where('prodId', $id)->delete();

        // $ingredients = [];
        foreach ($validatedData['ingredientsList'] as $ingrId) {
            ProductIngredient::create([
                'ingrId' => $ingrId,
                'prodId' => $product->id,
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('delete', Product::class);

        Product::destroy($id);

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}
