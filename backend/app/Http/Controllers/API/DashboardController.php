<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use App\Services\PizzaService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $orderService;
    protected $pizzaService;
    
    public function __construct(OrderService $orderService, PizzaService $pizzaService)
    {
        $this->orderService = $orderService;
        $this->pizzaService = $pizzaService;
    }
    
    public function index()
    {
        $totalRevenue = $this->orderService->getTotalRevenue();
        $popularPizzas = $this->pizzaService->getPopularPizzas(5);
        
        $lastMonthSales = $this->orderService->getSalesByDate(
            now()->subMonth()->startOfMonth()->format('Y-m-d'),
            now()->subMonth()->endOfMonth()->format('Y-m-d')
        );
        
        return response()->json([
            'total_revenue' => $totalRevenue,
            'popular_pizzas' => $popularPizzas,
            'last_month_sales' => $lastMonthSales,
        ]);
    }
    
    public function salesByDateRange(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        
        $sales = $this->orderService->getSalesByDate(
            $request->start_date,
            $request->end_date
        );
        
        return response()->json($sales);
    }
}