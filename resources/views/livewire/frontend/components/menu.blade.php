<?php $menuitems = \App\Models\MenuItems::orderBy('order_id', 'asc')->get(); ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light
    @if($this->page && $this->page->route != 'offerte-aanvragen') sticky-top @else sticky-top @endif">
    <div class="container menu-container">

        {{-- Logo --}}
        <a class="navbar-brand" href="/index">
            <img class="logo" alt="Escaperoom Kootwijkerbroek logo" src="{{ asset('/storage/images/frontend/uploads/logo_escaperoomkootwijkerbroek.png') }}">
        </a>

        {{-- Mobile toggle --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">

            <ul class="navbar-nav">

                @foreach($menuitems->where('parent_id', 0) as $menuitem)

                    @php
                        // Alle children ophalen
                        $children = $menuitems->where('parent_id', $menuitem->id);
                        // Voor active class
                        $childRoutes = $children->map(fn($item) => optional($item->page)->route)->filter();
                    @endphp

                    @if($children->count())
                        {{-- Dropdown parent (Escaperooms of andere) --}}
                        <li class="nav-item dropdown">
                            <span class="nav-link dropdown-toggle
                                @if($childRoutes->contains($this->slug)) active @endif">
                                {{ $menuitem->title }}
                            </span>

                            <ul class="dropdown-menu">
                                @foreach($children as $child)
                                    @if(optional($child->page)->route)
                                        <li>
                                            <a class="dropdown-item
                                                @if(optional($child->page)->route === $this->slug) active @endif"
                                               href="/{{ optional($child->page)->route }}">
                                                {{ $child->title }}
                                            </a>
                                        </li>
                                    @else
                                        {{-- Child heeft geen page_id --}}
                                        <li>
                                            <span class="dropdown-item">{{ $child->title }}</span>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @else
                        {{-- Normaal menu-item --}}
                        @if(optional($menuitem->page)->route)
                            <li class="nav-item">
                                <a class="nav-link
                                    @if(optional($menuitem->page)->route === $this->slug) active @endif"
                                   href="/{{ optional($menuitem->page)->route }}">
                                    {{ $menuitem->title }}
                                </a>
                            </li>
                        @endif
                    @endif

                @endforeach

            </ul>
        </div>
    </div>
</nav>

{{-- Hover dropdown CSS --}}
<style>
    /* Open dropdown on hover */
    .navbar .dropdown:hover .dropdown-menu {
        display: block;
        margin-top: 0;
    }

    /* Parent niet klikbaar */
    .navbar .dropdown-toggle {
        cursor: default;
    }
</style>
