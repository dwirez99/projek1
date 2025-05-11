<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $username = '';
    public string $email = '';
    public string $notelp = '';
    public string $alamat = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'notelp' => ['required', 'regex:/^[0-9]{10,15}$/', 'unique:' . User::class],
            'alamat' => ['required','string','max:255'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        $user->assignRole('orangtua');

        event(new Registered($user));


        // event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirectIntended(route('home', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Buat Akun Baru')" :description="__('Masukan Detail Infromasi Di bawah sini')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-6">
        <!-- Name -->
        <flux:input
            wire:model="name"
            :label="__('Nama Lengkap')"
            type="text"
            required
            autofocus
            autocomplete="name"
            :placeholder="__('Nama Lengkap')"
        />


        <flux:input
            wire:model="username"
            :label="__('Nama Panggilan')"
            type="text"
            required
            autofocus
            autocomplete="username"
            :placeholder="__('Masukan Username')"
        />

        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Alamat Email')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
        />

        <flux:input
            wire:model="notelp"
            :label="__('Nomor Telepon')"
            type="tel"
            required
            autocomplete="tel"
            placeholder="08123456789"
        />

        <flux:input
            wire:model="alamat"
            :label="__('Alamat Rumah')"
            type="alamat"
            required
            autocomplete="alamat"
            placeholder="Rt000,RW000,Ds...,Kec....,"
        />


        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('Password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Password')"
        />

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('Pastikan password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Pastikan password')"
        />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('Sudah Punya Akun?') }}
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
</div>
