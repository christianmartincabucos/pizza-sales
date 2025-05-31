<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{
    use HasFactory;
    
    protected $fillable = ['order_id', 'pizza_id', 'quantity'];
    
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
    
    public function pizza(): BelongsTo
    {
        return $this->belongsTo(Pizza::class);
    }
}