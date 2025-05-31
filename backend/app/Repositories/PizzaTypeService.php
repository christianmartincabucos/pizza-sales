<?php

namespace App\Services;

use App\Repositories\Interfaces\PizzaTypeRepositoryInterface;

class PizzaTypeService
{
    protected $pizzaTypeRepository;
    
    public function __construct(PizzaTypeRepositoryInterface $pizzaTypeRepository)
    {
        $this->pizzaTypeRepository = $pizzaTypeRepository;
    }
    
    public function getAllPizzaTypes()
    {
        return $this->pizzaTypeRepository->all();
    }
    
    public function createPizzaType(array $data)
    {
        return $this->pizzaTypeRepository->create($data);
    }
}