<?php
namespace App\Livewire\Auth\Configurator\ColorCategory\Color;
use App\Models\ColorCategory;
use App\Models\ColorFilterValue;
use App\Models\FilterValue;
use App\Models\MenuItems;
use App\Models\Page;
use App\Models\Project;
use App\Models\ProjectCategories;
use App\Models\ProjectImages;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\LivewireFilepond\WithFilePond;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Create extends Component
{

    public $color;
    public $colorCategory;

    public $color_code;
    public $title;
    public $colorCategory_id;
    public $color_images = [];
    public $existing_color_images = [];

    public $latestColor;

    public $color_filter = [];

    public $structure_filter;

    use WithFilePond;
    use WithFileUploads;

    protected $rules = [
        'title' => 'required',
    ];


    public function mount($id) {
        \App\Models\Color::create();
        $this->colorCategory_id = $id;
        $this->colorCategory = ColorCategory::find($id);
        $this->latestColor = \App\Models\Color::orderBy('created_at', 'desc')->first();

    }

    #[On('refresh-the-component')]
    public function render()
    {
        $this->structure_filter = FilterValue::where('filter_id', 1)->get();
        $this->existing_color_images = $this->latestColor->getMedia('color_images');
        return view('livewire.auth.configurator.colorCategories.color.create')->layout('components.layouts.adminapp');
    }

    public function storeColor() {


        $this->validate();


        $this->latestColor->update([
            'title' => $this->title,
            'color_code' => $this->color_code,
            'color_category_id' => $this->colorCategory_id
        ]);



        foreach($this->color_filter as $filter) {
            ColorFilterValue::create(['filter_value_id' => $filter, 'color_id' => $this->latestColor->id]);
        }


        session()->flash('success','De kleur is toegevoegd');
        return $this->redirect('/auth/configurator/colorCategories/'.$this->colorCategory_id.'/color', navigate: true);
    }

    public function cancelColor() {
        return $this->redirect('/auth/configurator/colorCategories/'.$this->colorCategory_id.'/color', navigate: true);
    }

    public function updateImageOrder($list) {
        foreach($list as $item) {
            Media::where('id', $item['value'])->update(['order_column' => $item['order']]);
        }
        $this->dispatch('updated');
    }


    public function removeExistingFiles($id) {
        $mediaItems = $this->latestColor->getMedia('color_images');
        foreach($mediaItems as $mediaitem) {

            if($mediaitem->id == $id) {
                $mediaitem->delete();
            }
        }
        $this->dispatch('refresh-the-component');
    }

    public function uploadFiles()
    {
        if($this->color_images) {
            $files = collect($this->color_images);
            foreach($files as $file) {
                if(Storage::disk('tmp')->exists($file->getFileName())) {
                    $this->latestColor->addMedia($file->getRealPath())->toMediaCollection('color_images');
                }
            }

            $this->dispatch('refresh-the-component');
            $this->dispatch('pondCompleteReset');
        }
    }
}
