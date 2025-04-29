<?php

namespace App\Livewire\Auth\Magazine;

use App\Models\MenuItems;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class Magazine extends Component
{
    public $user;
    public $name;
    public $email;

    public $password_confirmation;
    public $password;


    use WithFileUploads;

public function mount() {
    $this->user = Auth::user();
    $this->name = $this->user->name;
    $this->email = $this->user->email;
    return view('livewire.auth.account.account')->layout('components.layouts.adminapp');
}

    public function render()
    {

        return view('livewire.auth.account.account')->layout('components.layouts.adminapp');
    }



    public function rules() {
        return [
            'email' => 'required|string|email|unique:users,email,' .$this->user->id,
            'name' => 'required',
        ];
    }
    public function passwordRules() {
        return [
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8'
        ];
    }

    public function update() {
        $this->validate($this->rules());

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        if($this->password) {
            $this->validate($this->passwordRules());

            $this->user->update([
                'password' => Hash::make($this->password)
            ]);

        }

        session()->flash('success','Account bijgewerkt');

        return $this->redirect('/auth/account', navigate: true);
    }


}
