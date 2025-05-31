<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Support\Facades\DB;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function __construct(Order $model)
    {
        parent::__construct($model);
    }
    
    public function getSalesByDate($startDate, $endDate)
    {
        return DB::table('orders')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('pizzas', 'order_details.pizza_id', '=', 'pizzas.id')
            ->whereBetween('orders.date', [$startDate, $endDate])
            ->select(
                'orders.date',
                DB::raw('COUNT(DISTINCT orders.id) as order_count'),
                DB::raw('SUM(order_details.quantity) as total_pizzas'),
                DB::raw('SUM(order_details.quantity * pizzas.price) as revenue')
            )
            ->groupBy('orders.date')
            ->orderBy('orders.date')
            ->get();
    }
    
    public function getTotalRevenue()
    {
        return DB::table('orders')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('pizzas', 'order_details.pizza_id', '=', 'pizzas.id')
            ->select(
                DB::raw('SUM(order_details.quantity * pizzas.price) as total_revenue'),
                DB::raw('COUNT(DISTINCT orders.id) as total_orders'),
                DB::raw('SUM(order_details.quantity) as total_pizzas')
            )
            ->first();
    }

    public function cursorPaginate(?int $cursor = null, string $direction = 'next', int $limit = 20, array $filters = []): array
    {
        $query = $this->model->newQuery()
            ->with(['details', 'details.pizza', 'details.pizza.pizzaType']);

        if (!empty($filters)) {
            if (isset($filters['start_date'])) {
                $query->whereDate('date', '>=', $filters['start_date']);
            }
            
            if (isset($filters['end_date'])) {
                $query->whereDate('date', '<=', $filters['end_date']);
            }
        }
        
        $total = $query->count();
        
        $paginatedQuery = clone $query;
        
        if ($cursor !== null) {
            if ($direction === 'next') {
                $paginatedQuery->where('id', '>', $cursor);
                $paginatedQuery->orderBy('id', 'asc');
            } else {
                $paginatedQuery->where('id', '<', $cursor);
                $paginatedQuery->orderBy('id', 'desc');
            }
        } else {
            $paginatedQuery->orderBy('id', 'asc');
        }
        
        $orders = $paginatedQuery->limit($limit + 1)->get();
        
        $hasMore = $orders->count() > $limit;
        
        $firstId = $orders->isNotEmpty() ? $orders->first()->id : null;
        $lastId = $orders->isNotEmpty() ? $orders->last()->id : null;
        
        if ($hasMore) {
            $orders = $orders->slice(0, $limit);
            $lastId = $orders->isNotEmpty() ? $orders->last()->id : null;
        }
        
        if ($direction === 'next') {
            $nextCursor = $hasMore ? $lastId : null;
            
            $hasPrevious = $firstId !== null && $this->model->where('id', '<', $firstId)->exists();
            $prevCursor = $hasPrevious ? $firstId : null;
        } else {
            $nextCursor = $firstId;
            $prevCursor = $hasMore ? $lastId : null;
            $orders = $orders->reverse()->values();
        }
        
        $currentPage = 1;
        if ($cursor !== null) {
            $position = $this->model->where('id', '<', $cursor)->count();
            $currentPage = floor($position / $limit) + 1;
        }
        
        $totalPages = ceil($total / $limit);
        
        return [
            'data' => $orders->values(),
            'next_cursor' => $nextCursor,
            'prev_cursor' => $prevCursor,
            'total' => $total,
            'has_more' => $hasMore,
            'current_page' => $currentPage,
            'total_pages' => $totalPages
        ];
    }

    public function getStatistics(array $filters = []): array
    {
        $query = DB::table('orders')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('pizzas', 'order_details.pizza_id', '=', 'pizzas.id');
        
        if (!empty($filters)) {
            if (isset($filters['start_date'])) {
                $query->whereDate('orders.date', '>=', $filters['start_date']);
            }
            
            if (isset($filters['end_date'])) {
                $query->whereDate('orders.date', '<=', $filters['end_date']);
            }
        }
        
        $results = $query->select(
            DB::raw('COUNT(DISTINCT orders.id) as orders_count'),
            DB::raw('SUM(order_details.quantity * pizzas.price) as total_order_value')
        )->first();

        if (!$results) {
            return [
                'orders_count' => 0,
                'total_order_value' => 0,
                'average_order_value' => 0
            ];
        }
        
        $avgValue = $results->orders_count > 0 
            ? round($results->total_order_value / $results->orders_count, 2) 
            : 0;
        
        return [
            'orders_count' => $results->orders_count,
            'total_order_value' => $results->total_order_value,
            'average_order_value' => $avgValue
        ];
    }

    public function createOrder(array $data)
    {
        return $this->model->create($data);
    }

    public function updateOrder(array $data, $id)
    {
        $order = $this->model->findOrFail($id);
        $order->update($data);
        return $order;
    }

    public function deleteOrder($id)
    {
        $order = $this->model->findOrFail($id);
        return $order->delete();
    }

    public function getOrder($id)
    {
        return $this->model->with(['details', 'details.pizza', 'details.pizza.pizzaType'])->findOrFail($id);
    }
}