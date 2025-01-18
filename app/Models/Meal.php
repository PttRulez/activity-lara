<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Meal extends BaseModel
{
    public function foods(): HasMany
    {
        return $this->hasMany(FoodInMeal::class, 'meal_id');
    }
}
