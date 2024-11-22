<?php

namespace App\Http\Controllers;

use App\Models\Order;
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
        $isAdminOrManager = Auth::user()->role === 'admin' || Auth::user()->role === 'manager';

        if ($isAdminOrManager) {
            $query = Order::query()
                ->distinct()
                ->select([
                    'orders.id',
                    'orders.orderDate',
                    'orders.userId',
                    'orders.created_at',
                    'orders.updated_at',
                    'users.name as userName',
                    'users.email as userEmail'
                ])
                ->leftJoin('users', 'orders.userId', '=', 'users.id')
                ->with(['details' => function ($query) {
                    $query->select('order_details.*', 'product_variations.name as variantName')
                        ->leftJoin('product_variations', 'order_details.productVariationId', '=', 'product_variations.id');
                }])
                ->with(['status' => function ($query) {
                    $query->select([
                        'order_status_history.id',
                        'order_status_history.orderId',
                        'order_status_history.orderStatusId',
                        'order_status_history.created_at',
                        'os.name as statusName'
                    ])
                        ->leftJoin('order_status as os', 'order_status_history.orderStatusId', '=', 'os.id')
                        ->orderBy('order_status_history.created_at', 'desc');
                }])
                // only take order where there is a status record
                ->whereHas('status')
                ->orderBy('orders.orderDate', 'desc');
        } else {
            $query = Order::query()
                ->distinct()
                ->select([
                    'orders.id',
                    'orders.orderDate',
                    'orders.userId',
                    'orders.created_at',
                    'orders.updated_at'
                ])
                ->where('orders.userId', Auth::id())
                ->with(['details' => function ($query) {
                    $query->select('order_details.*', 'product_variations.name as variantName')
                        ->leftJoin('product_variations', 'order_details.productVariationId', '=', 'product_variations.id');
                }])
                ->with(['status' => function ($query) {
                    $query->select([
                        'order_status_history.id',
                        'order_status_history.orderId',
                        'order_status_history.orderStatusId',
                        'order_status_history.created_at',
                        'os.name as statusName'
                    ])
                        ->leftJoin('order_status as os', 'order_status_history.orderStatusId', '=', 'os.id')
                        ->orderBy('order_status_history.created_at', 'desc');
                }])
                ->whereHas('status')
                ->orderBy('orders.orderDate', 'desc');
        }

        $orders = $query->get();

        return view('orders.index', compact('orders'));
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

        $validatedData = $request->validate([
            'productId' => 'required|integer',
            'variantId' => 'required|integer',
            'qty' => 'required|integer|min:0',
            'orderDate' => 'required|date',
            'comment' => 'nullable|string',
        ]);
        // dd($request->all());


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

        return redirect()->back()->with('success', 'Commande créée avec succès');
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

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'statusId' => 'required|integer',
        ]);

        $order = Order::findOrFail($id);
        $order->status()->attach($validatedData['statusId']);

        return redirect()->back()->with('success', 'Commande mise à jour avec succès');
    }

    /**
     * Bulk update the specified orders.
     */
    public function bulkUpdate(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'orders' => 'required|array',
            'orders.*.orderId' => 'required|integer',
            'orders.*.statusId' => 'required|integer'
        ]);

        foreach ($validatedData['orders'] as $orderData) {
            $order = Order::findOrFail($orderData['orderId']);
            $order->status()->attach($orderData['statusId']);
        }

        return redirect()->route('products.index')->with('success', 'Commandes mises à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // ne peux detruire que si orderDate > today 8:00
        $order = Order::findOrFail($id);
        $orderDate = $order->orderDate;
        $today = date('Y-m-d 08:00:00');
        // ou qu il ny a aucun status
        if ($orderDate > $today || $order->status->count() === 0) {
            $order->delete();
            return redirect()->back()->with('success', 'Commande supprimée avec succès');
        } else {
            return redirect()->back()->with('error', 'Impossible de supprimer cette commande');
        }
    }
}
