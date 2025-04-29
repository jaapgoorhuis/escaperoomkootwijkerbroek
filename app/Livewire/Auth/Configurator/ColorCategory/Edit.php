<?php

namespace App\Livewire\Auth\Configurator\ColorCategory;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\LivewireFilepond\WithFilePond;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Edit extends Component
{
    public $title;
    public $id;
    public $color_category;
    public $color_category_tumbnail = [];
    public $existing_color_category_tumbnail = [];
    public $validationResult;

    use WithFilePond;
    use WithFileUploads;

    public function mount() {
        $this->id = Route::current()->parameter('id');
        $this->color_category = \App\Models\ColorCategory::where('id', $this->id)->first();
        $this->title = $this->color_category->title;
    }

    public function rules()
    {
        return [
            'title' => 'required|min:2|unique:color_categories,title,' . $this->id,
        ];
    }

    #[On('refresh-the-component')]
    public function render()
    {
        $this->existing_color_category_tumbnail = $this->color_category->getMedia('tumbnail');
        return view('livewire.auth.configurator.colorCategories.edit')->layout('components.layouts.adminapp');
    }

    public function update() {
        $this->validate($this->rules());

        $this->color_category->update([
            'title' => $this->title
        ]);

        session()->flash('success','De aanpassingen zijn opgeslagen');
        return $this->redirect('/auth/configurator/colorCategories', navigate: true);
    }

    public function cancelColorCategory() {
        return $this->redirect('/auth/configurator/colorCategories', navigate: true);
    }



    public function removeExistingFiles($id) {

        $mediaItems = $this->color_category->getMedia('tumbnail');
        foreach($mediaItems as $mediaitem) {
            if($mediaitem->id == $id) {
                $mediaitem->delete();
            }
        }
    }

    public function uploadFiles()
    {
        $mediaItems = $this->color_category->getMedia('tumbnail');
        foreach ($mediaItems as $mediaitem) {
            $mediaitem->delete();
        }

        if ($this->color_category_tumbnail) {
            $files = collect($this->color_category_tumbnail);

            foreach ($files as $file) {
                if (Storage::disk('tmp')->exists($file->getFileName())) {
                    $this->color_category->addMedia($file->getRealPath())->toMediaCollection('tumbnail');
                }
            }
            $this->dispatch('pondCompleteReset');
            $this->dispatch('refresh-the-component');
        }
    }
}
