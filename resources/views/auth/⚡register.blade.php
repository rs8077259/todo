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

<div>
    <section class="flex items-center justify-center">
        <form action="" class="w-65 bg-blue-50 p-2 rounded" wire:submit="save">
            @csrf
            {{-- Always remember that you are absolutely unique. Just like everyone else. - Margaret Mead --}}
            <x-input type="email" hint="your email address" icon="user" wire:model="email">

                <x-slot:label>
                    <span>email</span>
                </x-slot:label>
            </x-input>
            <x-input type="password" hint="your password" icon="key" wire:model="password">

                <x-slot:label>
                    <span>password</span>
                </x-slot:label>
            </x-input>
            <x-input type="password" hint="your password" icon="key" wire:model="password_confermation">

                <x-slot:label>
                    <span>confirm password</span>
                </x-slot:label>
            </x-input>
            <x-toggle label="Remember Me" />
            <x-button submit>submit</x-button>
        </form>
    </section>
</div>