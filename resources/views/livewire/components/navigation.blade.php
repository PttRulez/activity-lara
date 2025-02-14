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
<header>
  <nav class="navbar text-primary ">
    <div class="navbar-start gap-5 invisible md:visible">
      <a wire:navigate href='/' id='#logo' class='text-4xl font-bold hover:bg'>
        <i class="fa-solid fa-medal"></i>
      </a>
      <x-menu class="menu-horizontal text-2xl hidden lg:flex">
        <x-menu-item title="{{ __('navbar.Diary') }}" link="{{ route('diaries') }}" />
        <x-menu-item title="{{ __('navbar.Activities') }}" link="{{ route('activities') }}" />
        <x-menu-item title="{{ __('navbar.Food') }}" link="{{ route('foods') }}" />
      </x-menu>
    </div>

    <div class="navbar-center md:hidden">
      <a wire:navigate href='/' id='#logo' class='text-4xl font-bold hover:bg'>
        <i class="fa-solid fa-medal"></i>
      </a>
    </div>

    <div class="navbar-end">
      {{-- Desktop dropdown --}}
      <x-dropdown label="{{ auth()->user()->name }}" class="text-2xl bg-base-100 hidden md:block" icon="o-user" right>
        <x-menu class="text-neutral-content text-2xl">
          <x-menu-item title="{{ __('navbar.Settings') }}" link="{{ route('settings') }}" />
          <x-menu-item title="{{ __('navbar.Logout') }}" wire:click="logout" icon="c-arrow-left-start-on-rectangle"
            class="text-neutral-content" />
        </x-menu>
      </x-dropdown>
      {{-- End Desktop dropdown --}}

      {{-- Mobile Dropdown --}}
      <x-dropdown ight>
        <x-slot:trigger class="md:hidden">
          <x-button>
            <x-heroicon-o-bars-3 class="h-12 w-12" />
          </x-button>
        </x-slot:trigger>
        <x-menu class="text-neutral-content text-xl">
          <x-menu-item title="{{ __('navbar.Diary') }}" link="{{ route('diaries') }}" />
          <x-menu-item title="{{ __('navbar.Activities') }}" link="{{ route('activities') }}" />
          <x-menu-item title="{{ __('navbar.Food') }}" link="{{ route('foods') }}" />
          <x-menu-item title="{{ __('navbar.Settings') }}" link="{{ route('settings') }}" />
          <x-menu-item title="{{ __('navbar.Logout') }}" wire:click="logout" icon="c-arrow-left-start-on-rectangle" />
        </x-menu>
      </x-dropdown>
      {{-- End Mobile Dropdown --}}
    </div>
    </div>
  </nav>
</header>
