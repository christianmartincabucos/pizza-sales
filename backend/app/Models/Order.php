<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;
    
    protected $fillable = ['date', 'time'];
    
    public function details(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }
}