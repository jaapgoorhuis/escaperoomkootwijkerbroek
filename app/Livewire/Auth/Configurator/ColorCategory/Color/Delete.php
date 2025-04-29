<?php

namespace App\Livewire\Auth\Configurator\ColorCategory\Color;

use App\Models\ColorFilterValue;
use App\Models\MenuItems;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Delete extends Component
{
    public $id;
    public $categoryId;

    public function render()
    {
        $this->categoryId = Route::current()->parameter('id');
        $this->id = Route::current()->parameter('slug');
        return view('livewire.auth.configurator.colorCategories.color.delete')->layout('components.layouts.adminapp');
    }

    public function cancel() {
        return $this->redirect('/auth/configurator/colorCategories/'.$this->categoryId.'/color', navigate: true);
    }

    public function remove()
    {
        \App\Models\Color::find($this->id)->delete();
        ColorFilterValue::where('color_id', $this->id)->delete();
        session()->flash('success',"De kleur is verwijderd");

        return $this->redirect('/auth/configurator/colorCategories/'.$this->categoryId.'/color', navigate: true);
    }
}
