<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function getCartItems(): JsonResponse
    {
        $orders = Order::with(['details' => function (Builder $query) {
            $query->orderBy('created_at', 'desc');
        }])
            ->where('userId', Auth::id())
            ->orderBy('orderDate', 'desc')
            ->get();

        if (!$orders) {
            return response()->json(['items' => []]);
        }

        return response()->json(['orders' => $orders]);
    }

    public function updateQuantity(Request $request, $detailId): JsonResponse
    {
        $detail = OrderDetail::findOrFail($detailId);
        $detail->update(['qty' => $request->quantity]);
        return response()->json(['success' => true]);
    }

    public function removeItem($detailId): JsonResponse
    {
        $detail = OrderDetail::findOrFail($detailId);
        $detail->delete();
        return response()->json(['success' => true]);
    }
}
