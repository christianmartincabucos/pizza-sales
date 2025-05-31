<?php

namespace App\Services;

use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderService
{
    protected $orderRepository;
    
    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }
    public function getStatistics(array $filters = [])
    {
        return $this->orderRepository->getStatistics($filters);
    }
    public function getAllOrders()
    {
        return $this->orderRepository->all();
    }
    public function getPaginatedOrders($cursor = null, $direction = 'next', $limit = 20, array $filters = [])
    {
        return $this->orderRepository->cursorPaginate($cursor, $direction, $limit, $filters);
    }
    
    public function getSalesByDate($startDate, $endDate)
    {
        return $this->orderRepository->getSalesByDate($startDate, $endDate);
    }
    
    public function getTotalRevenue()
    {
        return $this->orderRepository->getTotalRevenue();
    }
    
    public function createOrder(array $data)
    {
        return $this->orderRepository->create($data);
    }

    public function updateOrder(array $data, $id)
    {
        return $this->orderRepository->update($data, $id);
    }

    public function deleteOrder($id)
    {
        return $this->orderRepository->delete($id);
    }
    
    public function getOrder($id)
    {
        return $this->orderRepository->show($id);
    }
}