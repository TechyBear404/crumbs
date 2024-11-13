<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class CategoryController extends Controller
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
        Gate::authorize('create', Category::class);

        $validatedData = $request->validate([
            'redirect_url' => 'nullable|string',
        ]);
        return view('category.create', ['redirect_url' => $validatedData['redirect_url']]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Category::class);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:App\Models\Category,name',
            'description' => 'nullable|string|max:255',
            'redirect_url' => 'nullable|string',
        ]);

        Category::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
        ]);

        $redirectUrl = $validatedData['redirect_url'] ?? route('category.create');

        return redirect($redirectUrl)->with('success', 'Catégorie créée avec succès');
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
