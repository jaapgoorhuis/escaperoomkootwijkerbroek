<?php

namespace App\Livewire\Auth\Configurator\ColorCategory;

use App\Models\Color;
use App\Models\MenuItems;
use App\Models\Project;
use Livewire\Component;
use Livewire\WithFileUploads;

class ColorCategory extends Component
{
    public $colorCategories;
    use WithFileUploads;


    public function render() {
        $toBeRemoved = \App\Models\ColorCategory::where('title', null)->get();

        foreach($toBeRemoved as $removed) {
            $removed->delete();
        }

        $this->colorCategories = \App\Models\ColorCategory::orderBy('order_id', 'asc')->get();
        return view('livewire.auth.configurator.colorCategories.colorCategories')->layout('components.layouts.adminapp');
    }

    public function createColorCategory() {
        return $this->redirect('/auth/configurator/colorCategories/create', navigate: true);
    }

    public function editColorCategory($id) {
        return $this->redirect('/auth/configurator/colorCategories/edit/'.$id, navigate: true);
    }

    public function updateColorCategoryOrder($list) {
        foreach($list as $item) {
            \App\Models\ColorCategory::where('id', $item['value'])->update(['order_id' => $item['order']]);
        }
    }

    public function deleteColorCategory($id) {
        return $this->redirect('/auth/configurator/colorCategories/delete/'.$id, navigate: true);
    }

    public function color($id) {
        return $this->redirect('/auth/configurator/colorCategories/'.$id.'/color', navigate: true);
    }


}
