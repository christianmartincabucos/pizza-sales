<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;
    
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    
    public function index(Request $request)
    {
        $cursor = $request->query('cursor', null);
        $direction = $request->query('direction', 'next');
        $limit = $request->query('limit', 15);
        $filters = [];
        
        if ($request->has('start_date')) {
            $filters['start_date'] = $request->input('start_date');
        }
        
        if ($request->has('end_date')) {
            $filters['end_date'] = $request->input('end_date');
        }
        
        if ($request->has('pizza_type_id')) {
            $filters['pizza_type_id'] = $request->input('pizza_type_id');
        }
        
        if ($request->has('size')) {
            $filters['size'] = $request->input('size');
        }
        
        $orders = $this->orderService->getPaginatedOrders($cursor, $direction, $limit, $filters);
        return response()->json($orders);
    }
    public function statistics(Request $request)
    {
        $filters = [];
        
        if ($request->has('start_date')) {
            $filters['start_date'] = $request->input('start_date');
        }
        
        if ($request->has('end_date')) {
            $filters['end_date'] = $request->input('end_date');
        }
        
        $statistics = $this->orderService->getStatistics($filters);
        
        return response()->json($statistics);
    }
    public function show($id)
    {
        $order = $this->orderService->getOrder($id);
        return response()->json($order);
    }
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'details' => 'required|array',
            'details.*.pizza_id' => 'required|exists:pizzas,id',
            'details.*.quantity' => 'required|integer|min:1',
        ]);
        
        $order = $this->orderService->createOrder($request->all());
        return response()->json($order, 201);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_name' => 'sometimes|required|string|max:255',
            'customer_email' => 'sometimes|required|email',
            'details' => 'sometimes|required|array',
            'details.*.pizza_id' => 'sometimes|required|exists:pizzas,id',
            'details.*.quantity' => 'sometimes|required|integer|min:1',
        ]);
        
        $order = $this->orderService->updateOrder($request->all(), $id);
        return response()->json($order);
    }
    public function destroy($id)
    {
        $this->orderService->deleteOrder($id);
        return response()->json(['message' => 'Order deleted successfully'], 204);
    }
}