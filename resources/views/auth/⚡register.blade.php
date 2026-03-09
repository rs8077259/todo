<?php

use Livewire\Component;
use App\Models\User;
use App\Models\Todo;
use TallStackUi\Traits\Interactions;
new #[Layout('layout::auth')] #[Title("login")] class extends Component {
    use Interactions;
    public string $email = "";
    public string $password = "";
    public string $password_confirmation = "";
    public bool $remember_me = false;

    public function register(): bool
    {
        $user = User::create([
            "name" => substr($this->email, 0, strpos($this->email, "@")),//taking the character till @
            "email" => $this->email,
            "password" => Hash::make($this->password)
        ]);
        Auth::login($user, $this->remember_me);
        $user->todo()->create([
            "name" => "general",
            "color" => "blue",
        ]);
        /* Todo::create([
            "user_id" => $user->id,
            "name" => "general",
            "color"=>"blue",
    ]); */

        return true;
    }
    public function save()
    {
        $validated = $this->validate([
            "email" => ['required', 'email', "unique:users"],
            "password" => ['required', 'min:3']
        ]);
        $this->register();
        $this->toast()->success("Registration Successfull", `Welcom $this->email you have been successfully registered`)->flash()->send();
        return redirect('/');
    }
};

?>

<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <section class="w-full max-w-md bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6 text-center">New User</h1>
        <form action="" wire:submit="save">
            @csrf
            <x-input type="email" hint="your email address" icon="user" wire:model="email">

                <x-slot:label>
                    <span>Email</span>
                </x-slot:label>
            </x-input>
            <x-input type="password" hint="your password" icon="key" wire:model="password">

                <x-slot:label>
                    <span>Password</span>
                </x-slot:label>
            </x-input>
            <x-input type="password" hint="your password" icon="key" wire:model="password_confermation">

                <x-slot:label>
                    <span>Confirm Password</span>
                </x-slot:label>
            </x-input>
            <div class="flex items-center justify-between">
                <x-toggle label="Remember Me" wire:model="remember_me" />
                <a href="/login" class="text-sm text-blue-600 hover:underline">Login</a>
            </div>
            <x-button submit class="w-full justify-center">
                Register Now
            </x-button>
        </form>
    </section>
</div>