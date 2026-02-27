<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use TallStackUi\Traits\Interactions;
new #[Layout('layouts::auth')] #[Title("login")] class extends Component {

    use Interactions;

    #[validate('required|email')]
    public string $email = "";
    #[validate('required|min:8')]
    public string $password = "";
    public bool $remember_me = false;

    public function save()
    {
        $this->validate();
        if(Auth::attempt([
            "email" => $this->email,
            "password" => $this->password,
        ],$this->remember_me))
        {
            Request::session()->regenerate();
            $this->toast()->success("Registration Successfull",`Welcom $this->email you have been successfully registered`)->flash()->send();
            return redirect('/');
        }
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
            <x-toggle label="Remember Me" wire:model="remember_me"/>
            <x-button submit>submit</x-button>
        </form>
    </section>

</div>