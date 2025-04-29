<?php

namespace App\Livewire\Auth\Configurator\ColorCategory;

use App\Models\MenuItems;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Delete extends Component
{
    public $id;

    public function render()
    {
        $this->id = Route::current()->parameter('id');
        return view('livewire.auth.configurator.colorCategories.delete')->layout('components.layouts.adminapp');
    }

    public function cancel() {
        return $this->redirect('/auth/configurator/colorCategories', navigate: true);
    }

    public function remove()
    {
        \App\Models\ColorCategory::find($this->id)->delete();
        \App\Models\Color::where('color_category_id', $this->id)->delete();

        session()->flash('success',"De kleurcategorie en onderliggende kleuren zijn verwijderd");

        return $this->redirect('/auth/configurator/colorCategories', navigate: true);
    }
}
