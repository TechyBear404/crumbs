<?php

namespace App\Http\Controllers;

use App\Models\ProductVariations;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
    {

        // dd($request->all());
        $validatedData = $request->validate([
            'productId' => 'required|integer',
            'variantId' => 'required|integer',
            'qty' => 'required|integer|min:0',
            'orderDate' => 'required|date',
            'comment' => 'nullable|string',
        ]);


        // get logged in user
        $user = User::find(Auth::id());

        $order = $user->orders()->where('orderDate', $validatedData['orderDate'])->first();
        if (!$order) {
            $order = $user->orders()->create([
                'userId' => $user->id,
                'orderDate' => $validatedData['orderDate'],
            ]);
        }

        $unitPrice = ProductVariations::find($validatedData['variantId'])->prices()->where('endDate', null)->first()->price;

        // dd($unitPrice);
        $order->details()->create([
            'orderId' => $order->id,
            'productVariationId' => $validatedData['variantId'],
            'qty' => $validatedData['qty'],
            'orderDate' => $validatedData['orderDate'],
            'comment' => $validatedData['comment'],
            'unitPrice' => $unitPrice,
        ]);

        return redirect()->route('products.index');
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
