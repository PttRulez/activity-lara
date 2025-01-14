<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>
<nav class='flex justify-between gap-10navbar border-b border-gray-700 items-center py-3'>
  <div class='flex text-primary text-xl font-bold h-full gap-10 items-end'>
    <a wire:navigate href='/' id='#logo' class='text-4xl font-bold'>
      <i class="fa-solid fa-medal"></i>
    </a>
    <a wire:navigate href='/activities'>
      Activities</a>
    <a wire:navigate href='/foods'>
      Food</a>
  </div>
  <div class="dropdown">
    <div tabindex="0" role="button" class="btn m-1 bg-inherit text-2xl">{{ auth()->user()->email }}</div>
    <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-52 p-2 shadow text-2xl">
      <li>
        <a wire:navigate href='/profile'>Profile</a>
      </li>
      <li wire:click="logout">
        <a>Logout</a>
      </li>
    </ul>
  </div>
</nav>
