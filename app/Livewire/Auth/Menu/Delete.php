<?php

namespace App\Livewire\Auth\Menu;

use App\Models\MenuItems;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Delete extends Component
{
    public $id;

    public function render()
    {
        $this->id = Route::current()->parameter('id');
        return view('livewire.auth.menu.delete')->layout('components.layouts.adminapp');
    }

    public function cancel() {
        return $this->redirect('/auth/menu', navigate: true);
    }

    public function remove()
    {
        MenuItems::find($this->id)->delete();

        session()->flash('success',"Het menu item is verwijderd");

        return $this->redirect('/auth/menu', navigate: true);
    }
}
