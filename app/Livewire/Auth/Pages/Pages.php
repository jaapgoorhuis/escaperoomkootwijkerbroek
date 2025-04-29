<?php

namespace App\Livewire\Auth\Pages;

use App\Models\Page;
use Livewire\Component;
use Livewire\WithFileUploads;

class Pages extends Component
{
    public $pages;
    public $title;
    public $route;
    public $is_active;

    use WithFileUploads;


    public function render()
    {
        $this->pages = Page::where('is_visible', '1')->get();
        return view('livewire.auth.pages.pages')->layout('components.layouts.adminapp');
    }

    public function createPage() {
        return $this->redirect('/auth/pages/create', navigate: true);
    }

    public function editPage($id) {
        return $this->redirect('/auth/pages/edit/'.$id, navigate: true);
    }

    public function pageBlocks($id) {
        return $this->redirect('/auth/pages/blocks/'.$id, navigate: true);
    }

    public function deletePage($id) {

        return $this->redirect('/auth/pages/delete/'.$id, navigate: true);
    }
}
