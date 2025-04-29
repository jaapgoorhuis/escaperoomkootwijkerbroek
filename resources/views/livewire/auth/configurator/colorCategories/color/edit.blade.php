<div>
    <div class="row justify-content-center mt-5">
        <div class="col-md-12 admin-page-container">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <p>Kleur bewerken</p>
                    <a class="close-card" href="" wire:click.prevent="cancelColor()"><i class="fa-solid fa-x"></i></a>
                </div>
                <div class="card-body">
                    <form  x-data="{ buttonDisabled: false}" x-on:livewire-upload-start="buttonDisabled = true" x-on:livewire-upload-finish="buttonDisabled = false" >
                        <h5 class="form-section-title">Kleur bewerken:</h5>

                        <br/>
                        <div class="form-section">

                            <div class="form-group mb-3">
                                <label for="title">Kleur titel:</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" wire:model="title">
                                @error('title')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="color_code">Kleurcode:</label>
                                <input type="text" class="form-control @error('color_code') is-invalid @enderror" id="color_code" wire:model="color_code">
                                @error('color_code')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div wire:ignore class="form-group mt-5">
                                <label for="color_code">Structuren:</label>
                                <select class="form-select @error('color_code') is-invalid @enderror" wire:model="color_filter" multiple id="multiple-select-field" data-placeholder="Selecteer één of meerdere structuren">
                                    @foreach( $this->structure_filter as $filter)
                                        <option  @if(in_array($filter->id, $this->color_filter)) selected @endif value="{{$filter->id}}">{{$filter->title}}</option>
                                    @endforeach
                                </select>

                                @error('color_filter')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="title">Kleur afbeelding</label>
                                <x-filepond::upload
                                    multiple="true"
                                    wire:model="color_images"
                                />
                            </div>

                            @if($this->existing_color_images)
                                <hr class="rounded">
                                <label for="title">Geüploade afbeeldingen</label>

                                <br/>
                                <div class="accordion" id="accordionExample">
                                    <ul style="list-style: none; padding:0px" wire:sortable="updateImageOrder">
                                        @foreach($this->existing_color_images as $items)
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
                                <button wire:click.prevent="storeColor()" :disabled="buttonDisabled" class="btn btn-success btn-block">Opslaan</button>
                                <button wire:click.prevent="cancelColor()" :disabled="buttonDisabled" class="btn btn-primary btn-block">Annuleren</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@script
<script>
    jQuery('#multiple-select-field').on('change', function (e) {
        const values = $(this).val();
        console.log(values);

    @this.color_filter = values;
    });
</script>
@endscript
