<?php

namespace App\Services;

use App\Repositories\Interfaces\PizzaRepositoryInterface;

class PizzaService
{
    protected $pizzaRepository;
    
    public function __construct(PizzaRepositoryInterface $pizzaRepository)
    {
        $this->pizzaRepository = $pizzaRepository;
    }
    
    public function getAllPizzas()
    {
        return $this->pizzaRepository->all();
    }
    
    public function getPopularPizzas($limit = 10)
    {
        return $this->pizzaRepository->getPopularPizzas($limit);
    }
    
    public function createPizza(array $data)
    {
        return $this->pizzaRepository->create($data);
    }
}