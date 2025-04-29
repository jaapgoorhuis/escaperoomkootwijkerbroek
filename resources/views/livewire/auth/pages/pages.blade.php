<div>
    <div class="row justify-content-center mt-5">
        <div class="col-md-12 admin-page-container">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if(Session::has('success'))
                            <div id="succes-alert" class="alert alert-success alert-warning alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close btn-close-alert-succes" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <a wire:click='createPage()' class="plus-icon">
                            <i class='bx bxs-file-plus plus-icon'></i>
                        </a>


                        <table class="table table-striped nowrap" style="width:100%">
                            <thead >
                            <tr>
                                <th>Pagina</th>
                                <th>Route</th>

                                <th style="width: 100px">Bewerken</th>
                                <th style="width: 100px">Verwijderen</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($this->pages as $page)
                                <tr wire:key="{{$page}}">
                                    <td>{{$page->title}}</td>
                                    <td>{{$page->route}}</td>

                                    <td style="max-width: 60px;">
                                        <button wire:click="editPage({{$page->id}})" class="btn btn-primary btn-sm">Bewerken</button>
                                    </td>
                                    <td style="max-width: 60px">
                                        <button wire:click="deletePage({{$page->id}})"  @if($page->is_removable == 0) disabled="disabled" @endif class="btn btn-danger btn-sm">Verwijderen</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
