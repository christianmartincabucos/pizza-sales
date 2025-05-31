<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PizzaType extends Model
{
    use HasFactory;
    
    protected $fillable = ['code', 'name', 'category', 'ingredients'];
    
    public function pizzas(): HasMany
    {
        return $this->hasMany(Pizza::class);
    }
}