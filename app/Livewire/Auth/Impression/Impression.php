<?php

namespace App\Livewire\Auth\Impression;

use App\Models\MenuItems;
use App\Models\Project;
use Livewire\Component;
use Livewire\WithFileUploads;

class Impression extends Component
{
    public $impressions;


    use WithFileUploads;


    public function render()
    {
        $emptyImpressions = \App\Models\Impression::where('title', '')->get();
        foreach($emptyImpressions as $emptyImpression) {
            $emptyImpression->delete();
        }
        $this->impressions = \App\Models\Impression::orderBy('order_id', 'asc')->get();
        return view('livewire.auth.impression.impression')->layout('components.layouts.adminapp');
    }

    public function create() {
        return $this->redirect('/auth/impressions/create', navigate: true);
    }

    public function edit($id) {
        return $this->redirect('/auth/impressions/edit/'.$id, navigate: true);
    }

    public function updateOrder($list) {

        foreach($list as $item) {
            \App\Models\Impression::where('id', $item['value'])->update(['order_id' => $item['order']]);
        }

    }


    public function delete($id) {

        return $this->redirect('/auth/impressions/delete/'.$id, navigate: true);
    }


}
