<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
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

        dd($request->all());
        $validatedData = $request->validate([
            // 'orderDate' => 'required|date',
            'details' => 'required|array',
            'details.*.productVariationId' => 'required|exists:product_variations,id',
            // 'details.*.qty' => 'required|integer|min:1',
            'details.*.comment' => 'nullable|string',
            'details.*.unitPrice' => 'required|numeric|min:0',
        ]);

        // dd($validatedData);

        $user = User::find($user->id);

        $order = $user->orders()->create($validatedData);

        $order->details()->create([
            'orderId' => $order->id,
            'orderDate' => Carbon::now(),
            'productVariationId' => $validatedData['details'][0]['productVariationId'],
            // 'qty' => $validatedData['details'][0]['qty'],
            'qty' => 1,
            'comment' => $validatedData['details'][0]['comment'],
            'unitPrice' => $validatedData['details'][0]['unitPrice'],
        ]);
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
