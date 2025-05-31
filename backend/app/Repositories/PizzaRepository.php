<?php

namespace App\Repositories;

use App\Models\Pizza;
use App\Repositories\Interfaces\PizzaRepositoryInterface;
use Illuminate\Support\Facades\DB;

class PizzaRepository extends BaseRepository implements PizzaRepositoryInterface
{
    public function __construct(Pizza $model)
    {
        parent::__construct($model);
    }
    
    public function getPopularPizzas($limit)
    {
        return DB::table('order_details')
            ->join('pizzas', 'order_details.pizza_id', '=', 'pizzas.id')
            ->join('pizza_types', 'pizzas.pizza_type_id', '=', 'pizza_types.id')
            ->select('pizza_types.name', 'pizzas.size', DB::raw('SUM(order_details.quantity) as total_quantity'))
            ->groupBy('pizza_types.name', 'pizzas.size')
            ->orderByDesc('total_quantity')
            ->limit($limit)
            ->get();
    }
}