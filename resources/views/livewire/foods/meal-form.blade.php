<?php

use Livewire\Volt\Component;

new class extends Component {
    public function submit(): void
    {
        $this->dispatch('meal-form-submitted');
    }
}; ?>

<div>
     <h1>Meal Form</h1>
    <button class="btn btn-primary"  wire:click="submit">meal submit</button>
</div>
