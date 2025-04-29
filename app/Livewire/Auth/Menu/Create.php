<?php

namespace App\Livewire\Auth\Menu;

use App\Models\MenuItems;
use App\Models\Page;
use App\Models\PageBlock;
use App\Models\Project;
use App\Models\ProjectCategories;
use App\Models\ProjectImages;
use http\Client\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Livewire\WithFileUploads;
use mysql_xdevapi\Schema;

class Create extends Component
{

    public $page_id = '1';
    public $pages;
    public $show_footer = '1';
    public $show_menu = '1';
    public $title;
    public $order_id;

    public $latest_menu_item;

    use WithFileUploads;

    public function mount() {
        $this->pages = Page::get();
        $this->latest_menu_item = MenuItems::orderBy('created_at', 'desc')->first();
    }


    protected $rules = [
        'title' => 'required|unique:menu',

    ];


    public function render()
    {

        return view('livewire.auth.menu.create')->layout('components.layouts.adminapp');
    }

    public function storeMenu() {
        $this->validate();

        if($this->latest_menu_item) {
            $this->order_id = $this->latest_menu_item->order_id +1;
        }
        else {
            $this->order_id = 1;
        }


        MenuItems::create([
            'title' => $this->title,
            'page_id' => $this->page_id,
            'order_id' => $this->order_id,
            'parent_id' => '0',
            'is_dropdown_parent' => '0',
            'show_footer' => $this->show_footer,
            'show_menu' => $this->show_menu,
        ]);

        session()->flash('success','Het menu item is toegevoegd');
        return $this->redirect('/auth/menu', navigate: true);
    }

    public function cancelMenu() {
        return $this->redirect('/auth/menu', navigate: true);
    }
}
