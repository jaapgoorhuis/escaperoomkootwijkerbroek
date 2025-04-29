<?php

namespace App\Livewire\Auth\Impression;

use App\Models\MenuItems;
use App\Models\Page;
use App\Models\PageBlock;
use App\Models\Project;
use App\Models\ProjectCategories;
use App\Models\ProjectImages;
use http\Client\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use mysql_xdevapi\Schema;

class Edit extends Component
{
    public $title;
    public $id;
    public $impression;

    public $impressionFile = [];

    public $existing_impression_file = [];


    use WithFileUploads;

    public function mount() {
        $this->id = Route::current()->parameter('id');
        $this->impression = \App\Models\Impression::where('id', $this->id)->first();
        $this->title = $this->impression->title;
    }

    public function rules()
    {
        return [
            'title' => 'required|min:2',
        ];
    }
    #[On('refresh-the-component')]
    public function render()
    {
        $this->existing_impression_file = $this->impression->getMedia('impressions');
        return view('livewire.auth.impression.edit')->layout('components.layouts.adminapp');
    }

    public function update() {
        $this->validate($this->rules());

        \App\Models\Impression::where('id', $this->id)->update([
            'title' => $this->title,

        ]);

        session()->flash('success','De aanpassingen zijn opgeslagen');
        return $this->redirect('/auth/impressions', navigate: true);
    }

    public function cancel() {
        return $this->redirect('/auth/impressions', navigate: true);
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
        $mediaItems = $this->impression->getMedia('impressions');
        foreach ($mediaItems as $mediaitem) {
            $mediaitem->delete();
        }

        if ($this->impressionFile) {
            $files = collect($this->impressionFile);

            foreach ($files as $file) {
                if (Storage::disk('tmp')->exists($file->getFileName())) {
                    $this->impression->addMedia($file->getRealPath())->toMediaCollection('impressions');
                }
            }
            $this->dispatch('pondCompleteReset');
            $this->dispatch('refresh-the-component');
        }
    }

    public function validateUploadedFile() {
        return true;
    }

    public function revert() {
        return true;
    }

}
