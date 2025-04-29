<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
    <div class="container">
        <a class="navbar-brand" href="#"><img class="logo" src="{{asset('storage/images/frontend/uploads/logo.png')}}"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                @foreach(\App\Models\MenuItems::orderBy('order_id', 'asc')->get() as $menuitem)
                    <li class="nav-item">
                        <a class="nav-link @if($this->slug == $menuitem->page->route) active @endif" aria-current="page" href="/{{$menuitem->page->route}}">{{$menuitem->title}}</a>
                    </li>
                @endforeach
            </ul>
        </div>
        <button class="btn btn-primary samenstellen"><a href="/offerte-aanvragen"><span class="hidden-xs hidden-sm hidden-md vissible-lg">Ontwerp jouw deur</span><span class="hidden-lg">Samenstellen</span></a></button>
    </div>
</nav>
