<?php

namespace App\Repositories;

use App\Models\PizzaType;
use App\Repositories\Interfaces\PizzaTypeRepositoryInterface;

class PizzaTypeRepository extends BaseRepository implements PizzaTypeRepositoryInterface
{
    public function __construct(PizzaType $model)
    {
        parent::__construct($model);
    }
}