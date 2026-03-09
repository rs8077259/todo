<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use TallStackUi\Traits\Interactions;

new #[Layout('layouts::auth')] #[Title('Login')] class extends Component {
    use Interactions;

    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required|min:8')]
    public string $password = '';

    public bool $remember_me = false;

    public function save()
    {
        $this->validate();

        if (Auth::attempt(
            [
                'email' => $this->email,
                'password' => $this->password,
            ],
            $this->remember_me
        )) {
            Request::session()->regenerate();

            $this->toast()
                ->success('Login successful', "Welcome {$this->email}, you are now logged in.")
                ->flash()
                ->send();

            return redirect()->intended('/');
        }

        $this->toast()
            ->error('Login failed', 'The provided credentials do not match our records.')
            ->flash()
            ->send();
    }
};
?>

<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <section class="w-full max-w-md bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Login</h1>

        <form wire:submit="save" class="space-y-4">
            @csrf

            <x-input type="email" hint="Your email address" icon="user" wire:model="email">
                <x-slot:label>
                    <span>Email</span>
                </x-slot:label>
            </x-input>

            <x-input type="password" hint="Your password" icon="key" wire:model="password">
                <x-slot:label>
                    <span>Password</span>
                </x-slot:label>
            </x-input>

            <div class="flex items-center justify-between">
                <x-toggle label="Remember Me" wire:model="remember_me" />
                <div class="flex justify-around items-center gap-1 m-4">
                    <a href="/register" class="text-sm text-blue-600 hover:underline">New User</a>
                    |
                    <a href="#" class="text-sm text-blue-600 hover:underline">Forgot password?</a>
                </div>
                
            </div>

            <x-button submit class="w-full justify-center mt-1">
                Login
            </x-button>
            
        </form>
    </section>
</div>
