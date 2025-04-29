<?php

namespace App\Livewire\Auth\Menu;

use App\Models\MenuItems;
use App\Models\Project;
use Livewire\Component;
use Livewire\WithFileUploads;

class Menu extends Component
{
    public $menu_items;


    use WithFileUploads;


    public function render()
    {
        $this->menu_items = MenuItems::orderBy('order_id', 'asc')->get();
        return view('livewire.auth.menu.menu')->layout('components.layouts.adminapp');
    }

    public function createMenu() {
        return $this->redirect('/auth/menu/create', navigate: true);
    }

    public function editMenu($id) {
        return $this->redirect('/auth/menu/edit/'.$id, navigate: true);
    }

    public function updateMenuItemOrder($list) {

        foreach($list as $item) {
            MenuItems::where('id', $item['value'])->update(['order_id' => $item['order']]);
        }

    }


    public function deleteMenu($id) {

        return $this->redirect('/auth/menu/delete/'.$id, navigate: true);
    }


}
