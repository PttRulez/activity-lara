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

{{-- <x-nav full-width>
  <x-slot:actions class="text-primary">
    <a wire:navigate href='/' id='#logo' class='text-4xl font-bold'>
      <i class="fa-solid fa-medal"></i>
    </a>
    <x-menu class="text-2xl flex-row">
      <x-menu-item title="{{ __('navbar.Activities') }}" link="{{ route('activities') }}" />
      <x-menu-item title="{{ __('navbar.Food') }}" link="{{ route('foods') }}" />
    </x-menu>
  </x-slot:actions>
  <x-slot:brand>
    <p>Hui</p>
  </x-slot:brand> --}}
{{-- <x-menu class="bg-base-300 rounded-box z-[1] p-2 shadow text-xl ">
    <x-menu-sub title="{{ auth()->user()->name }}" icon="o-home">
      <x-menu-item title="Users" icon="o-user" />
      <x-menu-item title="Folders" icon="o-folder" />
    </x-menu-sub>
  </x-menu> --}}
{{-- </x-nav> --}}

<nav class="navbar  text-primary">
  <div class="navbar-start gap-5">
    <a wire:navigate href='/' id='#logo' class='text-4xl font-bold hover:bg'>
      <i class="fa-solid fa-medal"></i>
    </a>
    <x-menu class="menu-horizontal text-2xl hidden lg:flex">
      <x-menu-item title="{{ __('navbar.Activities') }}" link="{{ route('activities') }}" />
      <x-menu-item title="{{ __('navbar.Food') }}" link="{{ route('foods') }}" />
    </x-menu>

  </div>

  <div class="navbar-end">
    {{-- Desktop dropdown --}}
    <x-dropdown label="{{ auth()->user()->name }}" class="text-2xl bg-base-100" icon="o-user" right>
      <x-menu class="text-neutral-content text-2xl">
        <x-menu-item title="{{ __('navbar.Settings') }}" link="{{ route('settings') }}" />
        <x-menu-item title="{{ __('navbar.Logout') }}" wire:click="logout" icon="c-arrow-left-start-on-rectangle"
          class="text-neutral-content" />
      </x-menu>
  </div>
  </x-dropdown>
  {{-- End Desktop dropdown --}}

  {{-- Mobile Dropdown --}}
  <div class="dropdown dropdown-end">
    <div tabindex="0" role="button" class="btn btn-ghost lg:hidden text-neutral-content text-2xl">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
      </svg>
    </div>
    <ul tabindex="0"
      class="lg:hidden menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
      <li><a>Item 1</a></li>
      <li>
        <a>Parent</a>
        <ul class="p-2">
          <li><a>Submenu 1</a></li>
          <li><a>Submenu 2</a></li>
        </ul>
      </li>
      <li><a>Item 3</a></li>
    </ul>
  </div>
  {{-- End Mobile Dropdown --}}
  </div>
</nav>

{{-- <nav class='flex justify-between gap-10navbar border-b border-gray-700 items-center py-3'>
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
</nav> --}}
