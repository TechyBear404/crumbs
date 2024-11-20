<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductIngredient;
use App\Models\ProductVariations;
use App\Models\Variation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('view', Product::class);

        // dd($request->all());

        $validatedData = $request->validate([
            'name' => 'nullable | string | max:255',
            'categoryId' => 'nullable | array',
            'categoryId.*' => 'integer'
        ]);

        $query = Product::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $validatedData['name'] . '%');
        }

        if ($request->has('categoryId')) {
            $query->whereIn('categoryId', $validatedData['categoryId']);
        }

        $orders = Order::with(['details.productVariation.product'])
            ->where('userId', Auth::id())
            ->get();
        $categories = Category::orderBy('name')->get();
        $products = $query->paginate(10);
        // $products = Product::paginate(10);
        return view('product.index', compact('products', 'categories', 'orders'));
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
            'description' => 'nullable|string|max:255',
            'categoryId' => 'required|integer',
            'ingredientsList' => 'required|array',
            'status' => 'required|in:available,unavailable',
            'variations' => 'required|array',
            'variations.*.size' => 'required|string|in:normal,large',
            'variations.*.price' => 'required|numeric|min:0',
        ]);

        $product = Product::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'categoryId' => $validatedData['categoryId'],
            'status' => $validatedData['status'],
        ]);

        // Create product ingredients
        foreach ($validatedData['ingredientsList'] as $ingredientId) {
            ProductIngredient::create([
                'ingredientId' => $ingredientId,
                'productId' => $product->id,
            ]);
        }

        $variationId = Variation::where('type', 'size')->first()->id;

        foreach ($validatedData['variations'] as $variation) {
            $productVariation = ProductVariations::create([
                'productId' => $product->id,
                'variationId' => $variationId,
                'name' => $variation['size']
            ]);

            $productVariation->prices()->create([
                'productVariationId' => $productVariation->id,
                'startDate' => Carbon::now(),
                'price' => $variation['price']
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

        foreach ($product->variations as $variation) {
            $variation->price = $variation->prices->where('endDate', null)->first()->price;
        }

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
            'description' => 'nullable|string|max:255',
            'categoryId' => 'required|integer',
            'ingredientsList' => 'required|array',
            'status' => 'required|in:available,unavailable',
            'variations' => 'required|array',
            'variations.*.size' => 'required|string|in:normal,large',
            'variations.*.price' => 'required|numeric|min:0',
        ]);

        $product = Product::findOrFail($id);

        // dd($product->variations);

        $product->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'categoryId' => $validatedData['categoryId'],
            'status' => $validatedData['status'],
        ]);


        // Update ingredients
        ProductIngredient::where('productId', $id)->delete();
        foreach ($validatedData['ingredientsList'] as $ingredientId) {
            ProductIngredient::create([
                'ingredientId' => $ingredientId,
                'productId' => $product->id,
            ]);
        }

        $variationId = Variation::where('type', 'size')->first()->id;

        // Collect the sizes from the validated data
        $newVariationSizes = collect($validatedData['variations'])->pluck('size')->toArray();

        // Delete variations that are not in the new variation sizes
        $product->variations()->whereNotIn('name', $newVariationSizes)->delete();

        // Update variations and prices
        foreach ($validatedData['variations'] as $variation) {

            $productVariation = $product->variations()->where('name', $variation['size'])->first();
            if (!$productVariation) {
                $productVariation = ProductVariations::create([
                    'productId' => $product->id,
                    'variationId' => $variationId,
                    'name' => $variation['size']
                ]);
            }

            if ($productVariation->prices()->where('endDate', null)->exists()) {
                $productVariation->prices()->where('endDate', null)->update([
                    'endDate' => Carbon::now()
                ]);
            }

            $productVariation->prices()->create([
                'startDate' => Carbon::now(),
                'price' => $variation['price']
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
