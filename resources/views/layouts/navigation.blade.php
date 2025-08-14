<style>
    /* Navbar Styling */
    .navbar {
        background: linear-gradient(90deg, #1a237e, #3949ab); /* nice professional gradient */
        padding: 0.6rem 2rem;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .navbar-brand {
        font-size: 1.6rem;
        font-weight: 700;
        letter-spacing: 1px;
        color: #fff;
        transition: color 0.3s;
    }

    .navbar-brand:hover {
        color: #ffca28; /* subtle hover color */
    }

    .nav-link {
        color: #ffffff;
        font-weight: 500;
        transition: color 0.3s, background-color 0.3s;
    }

    .nav-link.active {
        color: #ffca28;
        font-weight: 600;
    }

    .nav-link:hover {
        color: #ffca28;
        text-decoration: underline;
    }

    .btn.nav-link {
        color: #ffffff;
        background: transparent;
        border: none;
        padding: 0.25rem 0.5rem;
    }

    .dropdown-menu {
        min-width: 220px;
        border-radius: 0.5rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .dropdown-item {
        font-weight: 500;
        transition: background-color 0.3s, color 0.3s;
    }

    .dropdown-item:hover {
        background-color: #3949ab;
        color: #fff;
    }

    .badge {
        font-size: 0.75rem;
    }

    .navbar-toggler {
        border: 1px solid rgba(255, 255, 255, 0.5);
    }

    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30'
         xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba%28255, 255, 255, 0.9%29'
         stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
    }

</style>

<nav class="navbar navbar-expand-lg sticky-top">
    <a class="navbar-brand" href="{{ route('home') }}">DevRank</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
    </button>

    @php
        $navLinks = [
            ['name' => 'Home', 'route' => 'home'],
            ['name' => 'About', 'route' => 'about'],
            ['name' => 'Services', 'route' => 'services'],
            ['name' => 'Events', 'route' => 'events.index'],
            ['name' => 'Coaching', 'route' => 'coaching.index'],
            ['name' => 'Contact', 'route' => 'contact'],
        ];

        $languages = [
            ['label' => 'English', 'code' => 'en'],
            ['label' => 'Swahili', 'code' => 'sw'],
        ];
    @endphp

    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ms-auto d-flex align-items-lg-center gap-2">

            {{-- Public Navigation Links --}}
            @auth
                @if (!Auth::user()->isAdmin())
                    @foreach ($navLinks as $item)
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs($item['route']) ? 'active' : '' }}"
                                href="{{ route($item['route']) }}">
                                {{ $item['name'] }}
                            </a>
                        </li>
                    @endforeach
                @endif
            @else
                @foreach ($navLinks as $item)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs($item['route']) ? 'active' : '' }}"
                            href="{{ route($item['route']) }}">
                            {{ $item['name'] }}
                        </a>
                    </li>
                @endforeach
            @endauth

            {{-- Language Selector --}}
            <li class="nav-item dropdown">
                <button class="btn nav-link dropdown-toggle" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false" type="button">
                    {{ strtoupper(app()->getLocale()) }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                    @foreach ($languages as $lang)
                        <li>
                            <a class="dropdown-item" href="{{ route('setLocale', $lang['code']) }}">
                                {{ $lang['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>

            {{-- Authenticated User Dropdown --}}
            @auth
                @php
                    $unreadNotificationsCount = Auth::user()
                        ->customNotifications()
                        ->where('is_read', false)
                        ->count();
                @endphp

                <li class="nav-item dropdown">
                    <button class="btn nav-link dropdown-toggle d-flex align-items-center" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" type="button">
                        {{ Auth::user()->name ?? 'User' }}
                        @if ($unreadNotificationsCount > 0)
                            <span class="badge bg-danger ms-1">{{ $unreadNotificationsCount }}</span>
                        @endif
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        @if (Auth::user()->isAdmin())
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.notifications.index') }}">
                                    Notifications
                                    @if($unreadNotificationsCount > 0)
                                        <span class="badge bg-danger">{{ $unreadNotificationsCount }}</span>
                                    @endif
                                </a>
                            </li>
                        @else
                            <li>
                                <a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('notifications.index') }}">
                                    Notifications
                                    @if($unreadNotificationsCount > 0)
                                        <span class="badge bg-danger">{{ $unreadNotificationsCount }}</span>
                                    @endif
                                </a>
                            </li>
                        @endif
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
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
                {{-- Guest Links --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-light btn-sm px-3" href="{{ route('register') }}">Register</a>
                </li>
            @endauth

        </ul>
    </div>
</nav>
