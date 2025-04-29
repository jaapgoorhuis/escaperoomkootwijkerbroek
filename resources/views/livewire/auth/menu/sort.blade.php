<div wire:ignore>
    <div class="row justify-content-center mt-5" >
        <div class="col-md-12 admin-page-container">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <p>Project: <span class="color-gold">{{$project->title}}</span> - Afbeeldingen sorteren</p>
                    <a class="close-card" href="" wire:click.prevent="cancel()"><i class="fa-solid fa-x"></i></a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if(Session::has('success'))
                            <div id="succes-alert" class="alert alert-success alert-warning alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close btn-close-alert-succes" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(count($this->projectImages))
                        <table class="table table-striped nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th><i class="fa-solid fa-sort"></i></th>
                                <th>Afbeelding</th>
                            </tr>
                            </thead>
                            <tbody wire:sortable="updateProjectImageOrder">
                            @foreach($this->projectImages as $image)
                                <tr wire:sortable.item="{{$image->id}}" wire:key="project_{{$image->id}}">
                                    <td wire:sortable.handle class="sort-item"><i class="fa-solid fa-ellipsis-vertical"></i></td>
                                    <td wire:sortable.handle> <img style="height: 100px;" src="{{asset('/storage/images/frontend/projects/'.$project->friendly_route.'/'.$image->image)}}"</td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @else
                            <span>Er zijn nog geen afbeeldingen aan dit project toe gevoegd. Bewerk het project en voeg afbeeldingen toe om de afbeeldingen te kunnen sorteren</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
