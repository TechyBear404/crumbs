<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        Gate::authorize('create', Ingredient::class);

        $validatedData = $request->validate([
            'redirect_url' => 'nullable|string',
        ]);
        return view('ingredient.create', ['redirect_url' => $validatedData['redirect_url']]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Ingredient::class);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:App\Models\Ingredient,name',
            'description' => 'nullable|string|max:255',
            'isAllergen' => 'required|boolean',
            'redirect_url' => 'nullable|string',
        ]);

        Ingredient::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'isAllergen' => $validatedData['isAllergen'],
        ]);

        // dd($request->session()->get('ingredientsList'));
        // dd($validatedData['redirect_url']);


        $redirectUrl = $validatedData['redirect_url'] ?? route('ingredient.create');

        return redirect($redirectUrl)->with('success', 'Ingrédient créé avec succès')->with('ingredientsList', $request->session()->get('ingredientsList'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
