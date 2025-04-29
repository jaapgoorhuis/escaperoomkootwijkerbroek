<?php

namespace App\Livewire\Auth\Configurator\ColorCategory\Color;


use App\Models\ColorCategory;
use App\Models\FilterValue;
use App\Models\MenuItems;
use App\Models\Project;
use Livewire\Component;
use Livewire\WithFileUploads;

class Color extends Component
{
    public $color_items;
    public $colorCategory;

    public $colorCategory_id;

    public $structure_filter;

    use WithFileUploads;

    public function mount($id) {
        $this->colorCategory_id = $id;
    }

    public function render() {
        $toBeRemoved = \App\Models\Color::where('title', null)->get();
        $this->structure_filter = FilterValue::where('filter_id', 1)->get();
        foreach($toBeRemoved as $removed) {
            $removed->delete();
        }

        $this->colorCategory = ColorCategory::find($this->colorCategory_id);
        $this->color_items = \App\Models\Color::where('color_category_id', $this->colorCategory_id)->orderBy('order_id', 'asc')->get();
        return view('livewire.auth.configurator.colorCategories.color.color')->layout('components.layouts.adminapp');
    }

    public function createColor() {
        return $this->redirect('/auth/configurator/colorCategories/'.$this->colorCategory_id.'/color/create', navigate: true);
    }

    public function editColor($id) {
        return $this->redirect('/auth/configurator/colorCategories/'.$this->colorCategory_id.'/color/edit/'.$id, navigate: true);
    }

    public function updateColorItemList($list) {

        foreach($list as $item) {
            \App\Models\Color::where('id', $item['value'])->update(['order_id' => $item['order']]);
        }

    }

    public function deleteColor($id) {

        return $this->redirect('/auth/configurator/colorCategories/'.$this->colorCategory_id.'/color/delete/'.$id, navigate: true);
    }


}
