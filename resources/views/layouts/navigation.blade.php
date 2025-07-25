<nav class="navbar navbar-expand-lg sticky-top shadow-sm" style="background: linear-gradient(90deg, #0d47a1, #1976d2); padding-top: 0.75rem; padding-bottom: 0.75rem;">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold text-white ms-2" href="{{ route('home') }}" style="font-size: 1.5rem;">DevRank</a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto d-flex align-items-lg-center gap-2">
                <!-- Public Navigation -->
                @foreach([
                    ['name' => 'Home', 'route' => 'home'],
                    ['name' => 'About', 'route' => 'about'],
                    ['name' => 'Services', 'route' => 'services'],
                    ['name' => 'Events', 'route' => 'events.welcome'],
                    ['name' => 'Coaching', 'route' => 'coaching.index'],
                    ['name' => 'Contact', 'route' => 'contact'],
                ] as $item)
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is($item['route']) ? 'active' : '' }}"
                           href="{{ route($item['route']) }}"
                           style="color: #e3f2fd; font-weight: 500; transition: all 0.3s; {{ Route::is($item['route']) ? 'color: #ffffff; border-bottom: 2px solid #ffffff;' : '' }}">
                            {{ $item['name'] }}
                        </a>
                    </li>
                @endforeach

                <!-- Language Selector -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" data-bs-toggle="dropdown" style="color: #e3f2fd;">
                        {{ strtoupper(app()->getLocale()) }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('setLocale', 'en') }}">English</a></li>
                        <li><a class="dropdown-item" href="{{ route('setLocale', 'sw') }}">Swahili</a></li>
                    </ul>
                </li>

                <!-- Authenticated -->
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-bs-toggle="dropdown" style="color: #e3f2fd;">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                            @if(auth()->user()->role === 'admin')
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('login') ? 'active' : '' }}"
                           href="{{ route('login') }}"
                           style="color: #e3f2fd; font-weight: 500;">
                            Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-light btn-sm px-3"
                           href="{{ route('register') }}">
                            Register
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
