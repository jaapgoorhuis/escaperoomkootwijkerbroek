<?php

namespace App\Livewire\Auth\Configurator\ColorCategory;

use App\Models\Page;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\LivewireFilepond\WithFilePond;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Create extends Component
{
    public $order_id;
    public $title;
    public $color_category_tumbnail = [];
    public $latest_color_category;

    use WithFilePond;
    use WithFileUploads;

    public function mount() {
        \App\Models\ColorCategory::create();
        $this->latest_color_category = \App\Models\ColorCategory::orderBy('created_at', 'desc')->first();
    }


    protected $rules = [
        'title' => 'required|unique:color_categories',

    ];

    public function render()
    {
        return view('livewire.auth.configurator.colorCategories.create')->layout('components.layouts.adminapp');
    }

    public function storeColorCategory() {
        $this->validate();

        if($this->latest_color_category) {
            $this->order_id = $this->latest_color_category->order_id +1;
        }
        else {
            $this->order_id = 1;
        }

        $this->latest_color_category->update([
            'title' => $this->title,
            'order_id' => $this->order_id
        ]);

        session()->flash('success','De categorie is toegevoegd');
        return $this->redirect('/auth/configurator/colorCategories', navigate: true);
    }

    #[On('removeFiles')]
    public function removeFiles($filename) {
        Media::where('file_name',$filename)->delete();
    }

    public function uploadFiles()
    {
        if($this->color_category_tumbnail) {

            $files = collect($this->color_category_tumbnail);
            foreach($files as $file) {
                if(Storage::disk('tmp')->exists($file->getFileName())) {
                    $this->latest_color_category->addMedia($file->getRealPath())->toMediaCollection('tumbnail');
                }
            }
            $this->dispatch('updated');
        }
    }
    public function cancelColorCategory() {
        return $this->redirect('/auth/configurator/colorCategories', navigate: true);
    }
}
