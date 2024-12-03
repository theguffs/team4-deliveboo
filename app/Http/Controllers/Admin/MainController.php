<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class MainController extends Controller
{

    public function index(){

        //Ottengo il totale delle vendite e il numero di ordine per mese e anno
        $ordersStats = Order::selectRaw('YEAR(created_a) as year, MONTH(created_at) as month, COUNT(*) as total_orders, SUM(price) as total_sales')
        ->groupBy('year', 'month')
        ->groupBy('year', 'desc')
        ->groupBy('month', 'desc')
        ->get();

        return view('admin.dashboard', compact('ordersStats'));
    }

    public function dashboard()
    {
        
        return $this->index();
    }

}
