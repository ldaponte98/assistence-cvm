<nav class="navbar-vertical navbar">
    <div class="nav-scroller">
        <!-- Brand logo -->
        <a class="navbar-brand" href="">
            <img src="{{asset('images/logo.png')}}" alt="" />
            <label class="white">Asistencia CVM</label>
        </a>
        <!-- Navbar nav -->
        <ul class="navbar-nav flex-column" id="sideNavbar">
            @foreach ($user->profile->getMenu() as $father)
            <li class="nav-item">
                @if(count($father->children) == 0)
                    <a class="nav-link has-arrow active" href="{{ env('APP_URL') }}/{{ $father->path }}">
                        <i data-feather="{{ $father->icon }}" class="nav-icon icon-xs me-2"></i> {{ $father->title }}
                    </a>
                @else
                    <a class="nav-link has-arrow active collapsed " href="#!" data-bs-toggle="collapse"
                        data-bs-target="#nav{{$father->id}}" aria-expanded="false" aria-controls="nav{{$father->id}}">
                        <i data-feather="{{ $father->icon }}" class="nav-icon icon-xs me-2">
                        </i> {{ $father->title }}
                    </a>
                    <div id="nav{{$father->id}}" class="collapse " data-bs-parent="#sideNavbar">
                        <ul class="nav flex-column">
                            @foreach ($father->children as $son)
                            <li class="nav-item">
                                <a class="nav-link " href="{{ env('APP_URL') }}/{{ $son->path }}">
                                    {{ $son->title }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </li>
            @endforeach
        </ul>
    </div>
</nav>
