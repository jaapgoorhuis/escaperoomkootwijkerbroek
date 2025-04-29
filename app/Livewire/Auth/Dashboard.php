<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        if(Auth::check())
        {
            return view('livewire.auth.dashboard')->layout('components.layouts.adminapp');
        }

        return redirect()->route('login')
            ->withErrors([
                'email' => 'U moet eerst inloggen om het dashboard te kunnen gebruiken.',
            ])->onlyInput('email');

    }
}
