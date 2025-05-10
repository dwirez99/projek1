<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class DaftarPopout extends Component
{
    public $show = false;

    public function mount()
    {
        if (Auth::check() && Auth::user()->hasRole('orangtua')) {
            $this->show = true;
        }
    }

    public function render()
    {
        return view('livewire.daftar-popout');
    }
}
