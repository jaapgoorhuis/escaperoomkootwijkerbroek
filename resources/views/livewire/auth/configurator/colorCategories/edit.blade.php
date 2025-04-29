<div>
    <div class="row justify-content-center mt-5">
        <div class="col-md-12 admin-page-container">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <p>Kleur categorie bewerken</p>
                    <a class="close-card" href="" wire:click.prevent="cancelColorCategory()"><i class="fa-solid fa-x"></i></a>
                </div>
                <div class="card-body">
                    <form  x-data="{ buttonDisabled: false}" x-on:livewire-upload-start="buttonDisabled = true" x-on:livewire-upload-finish="buttonDisabled = false" >
                        <h5 class="form-section-title">Menu items:</h5>

                        <br/>
                        <div class="form-section">

                            <div class="form-group mb-3">
                                <label for="title">Kleur categorie titel:</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Homepagina" wire:model="title">
                                @error('title')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="title">Kleur categorie tumbnail</label>
                                <x-filepond::upload
                                    multiple="false"
                                    wire:model="color_category_tumbnail"
                                />
                            </div>

                            @if($this->existing_color_category_tumbnail)
                                <hr class="rounded">
                                <label for="title">Huidige tumbnail</label>

                                <br/>
                                <div class="accordion" id="accordionExample">
                                    <ul style="list-style: none; padding:0px" >
                                        @foreach($this->existing_color_category_tumbnail as $items)
                                            <li wire:sortable.item="{{$items->id}}" wire:key="items_{{$items->id}}" wire:sortable.handle>
                                                <div class="flex-grid">
                                                    <div class="col sorting-col">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </div>
                                                    <img src="{!! $items['original_url'] !!}" style="width:150px;"/>
                                                    <div class="align-right">
                                                        <button wire:click.prevent="removeExistingFiles({{$items['id']}})" class="btn btn-danger btn-sm">Verwijderen</button>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="d-grid gap-2">
                                <button wire:click.prevent="updateColorCategory()" :disabled="buttonDisabled" class="btn btn-success btn-block">Opslaan</button>
                                <button wire:click.prevent="cancelColorCategory()" :disabled="buttonDisabled" class="btn btn-primary btn-block">Annuleren</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
