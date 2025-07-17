<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm py-3">
    <div class="container-fluid">
        <a class="navbar-brand ms-2 fw-bold" href="{{ route('home') }}">DevRank</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto d-flex align-items-lg-center gap-2">
                <!-- Public Navigation -->
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('home') ? 'active' : '' }}" href="{{ route('home') }}">{{ __('Home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('about') ? 'active' : '' }}" href="{{ route('about') }}">{{ __('About') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('services') ? 'active' : '' }}" href="{{ route('services') }}">{{ __('Services') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('events') ? 'active' : '' }}" href="{{ route('events.index') }}">{{ __('Events') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('coaching') ? 'active' : '' }}" href="{{ route('coaching') }}">{{ __('Coaching') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('contact') ? 'active' : '' }}" href="{{ route('contact') }}">{{ __('Contact') }}</a>
                </li>

                <!-- Language Selector -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" data-bs-toggle="dropdown">
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
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a></li>
                            @if(auth()->user()->role === 'admin')
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('login') ? 'active' : '' }}" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('register') ? 'active' : '' }}" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
