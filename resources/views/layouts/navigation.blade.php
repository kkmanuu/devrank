<nav class="navbar navbar-expand-lg sticky-top shadow-sm" style="background: linear-gradient(90deg, #0d47a1, #1976d2);">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold text-white ms-2" href="{{ route('home') }}">DevRank</a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
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

                {{-- Language Selector Dropdown (all users) --}}
                <li class="nav-item dropdown">
                    <button class="btn nav-link dropdown-toggle text-white" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false" type="button">
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
                        <button class="btn nav-link dropdown-toggle text-white d-flex align-items-center" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" type="button">
                            {{ Auth::user()->name ?? 'User' }}
                            @if ($unreadNotificationsCount > 0)
                                <span class="badge bg-danger ms-1">{{ $unreadNotificationsCount }}</span>
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            @if (Auth::user()->isAdmin())
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        Admin Dashboard
                                    </a>
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
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
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
                        <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">
                            Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-light btn-sm px-3" href="{{ route('register') }}">
                            Register
                        </a>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>
