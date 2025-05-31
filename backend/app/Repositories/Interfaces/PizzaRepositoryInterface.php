<?php

namespace App\Repositories\Interfaces;

interface PizzaRepositoryInterface extends RepositoryInterface
{
    public function getPopularPizzas($limit);
}