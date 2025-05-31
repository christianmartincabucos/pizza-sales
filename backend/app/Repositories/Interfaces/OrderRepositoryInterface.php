<?php

namespace App\Repositories\Interfaces;

interface OrderRepositoryInterface extends RepositoryInterface
{
    public function getStatistics(array $filters = []): array;
    public function getSalesByDate($startDate, $endDate);
    public function getTotalRevenue();
    public function cursorPaginate(?int $cursor = null, string $direction = 'next', int $limit = 15, array $filters = []): array;
}