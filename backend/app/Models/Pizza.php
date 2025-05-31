<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pizza extends Model
{
    use HasFactory;
    
    protected $fillable = ['code', 'pizza_type_id', 'size', 'price'];
    
    public function pizzaType(): BelongsTo
    {
        return $this->belongsTo(PizzaType::class);
    }
    
    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }
}