<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm py-3">
    <div class="container-fluid">
        <!-- Logo / Brand -->
        <a class="navbar-brand ms-2 fw-bold" href="{{ route('home') }}">
            DevRank
        </a>

        <!-- Toggler for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible content -->
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto d-flex align-items-lg-center gap-2">
                <!-- Navigation Links -->
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('home') ? 'active' : '' }}" href="{{ route('home') }}">{{ __('home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('about') ? 'active' : '' }}" href="{{ route('about') }}">{{ __('about') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('services') ? 'active' : '' }}" href="{{ route('services') }}">{{ __('services') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('events') ? 'active' : '' }}" href="{{ route('services') }}">{{ __('events') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('coaching') ? 'active' : '' }}" href="{{ route('coaching') }}">{{ __('coaching') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('contact') ? 'active' : '' }}" href="{{ route('contact') }}">{{ __('contact') }}</a>
                </li>

                <!-- Language Selector -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ strtoupper(app()->getLocale()) }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                        <li><a class="dropdown-item" href="{{ route('setLocale', 'en') }}">English</a></li>
                        <li><a class="dropdown-item" href="{{ route('setLocale', 'sw') }}">Swahili</a></li>
                    </ul>
                </li>

                <!-- Auth Links -->
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">{{ __('dashboard') }}</a></li>
                            @if(auth()->user()->role === 'admin')
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('messages.logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('login') ? 'active' : '' }}" href="{{ route('login') }}">{{ __('login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('register') ? 'active' : '' }}" href="{{ route('register') }}">{{ __('register') }}</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
