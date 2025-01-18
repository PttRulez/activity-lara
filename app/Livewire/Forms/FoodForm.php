<?php

namespace App\Livewire\Forms;

use App\Models\Food;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FoodForm extends Form
{
    public ?Food $food = null;
    public string $foodName;
    public string $calories;
    public string $protein;
    public string $fat;
    public string $carbs;
    
    public function rules(): array
    {
        $foodNameRules = ['required', 'string', 'max:255'];
        if ($this->food) {
            $foodNameRules[] = Rule::unique('foods', 'name')->ignore($this->food->id)->where(function ($query)  {
                return $query->where('user_id', \Auth::id());
            });
        } else {
            $foodNameRules[] = Rule::unique('foods', 'name')->where(function ($query) {
                return $query->where('user_id', auth()->id());
            });
        }
        
        return [
            'foodName' => $foodNameRules,
            'calories' => ['required', 'integer'],
            'protein' => ['required', 'integer'],
            'fat' => ['required', 'integer'],
            'carbs' => ['required', 'integer'],
        ];
    }
    
}
