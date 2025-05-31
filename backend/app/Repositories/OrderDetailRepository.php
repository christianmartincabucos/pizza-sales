<?php

namespace App\Repositories;

use App\Models\OrderDetail;
use App\Repositories\Interfaces\OrderDetailRepositoryInterface;

class OrderDetailRepository extends BaseRepository implements OrderDetailRepositoryInterface
{
    public function __construct(OrderDetail $model)
    {
        parent::__construct($model);
    }
}