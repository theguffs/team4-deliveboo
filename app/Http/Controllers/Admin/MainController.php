<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Order;
use Illuminate\Http\Request;

class MainController extends Controller
{
    // Mostra il riepilogo degli ordini con tabella
    public function index($restaurantId)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);
        
        // Ottieni tutti gli ordini del ristorante
        $orders = Order::where('restaurant_id', $restaurantId)->get();

        return view('orders.index', compact('restaurant', 'orders'));
    }

    // Mostra le statistiche degli ordini
    public function showOrderStats($restaurantId)
    {
        $ordersStats = Order::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total_orders, SUM(price) as total_sales')
            ->where('restaurant_id', $restaurantId)
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        return view('orders.stats', compact('restaurant', 'ordersStats'));
    }
}

