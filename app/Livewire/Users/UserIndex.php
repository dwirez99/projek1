<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\User;

class UserIndex extends Component
{
    public function render()
    {
        $users = User::all();
        return view('livewire.users.user-index', compact('users'));
    }
}
