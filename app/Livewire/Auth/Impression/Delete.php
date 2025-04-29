<?php

namespace App\Livewire\Auth\Impression;

use App\Models\MenuItems;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Delete extends Component
{
    public $id;

    public function render()
    {
        $this->id = Route::current()->parameter('id');
        return view('livewire.auth.impression.delete')->layout('components.layouts.adminapp');
    }

    public function cancel() {
        return $this->redirect('/auth/impressions', navigate: true);
    }

    public function remove()
    {
        \App\Models\Impression::find($this->id)->delete();

        session()->flash('success',"De impressie is verwijderd");

        return $this->redirect('/auth/impressions', navigate: true);
    }
}
