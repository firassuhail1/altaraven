<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — @yield('title', 'Dashboard') | ALTARAVEN</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="bg-[#0a0a0a] text-ar-text font-sans antialiased" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">

        {{-- ── SIDEBAR ── --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed lg:static inset-y-0 left-0 z-40 w-64 bg-ar-dark border-r border-ar-border flex flex-col transition-transform duration-300">
            {{-- Logo --}}
            <div class="px-6 py-5 border-b border-ar-border">
                <a href="{{ route('admin.dashboard') }}" class="font-display text-2xl tracking-widest text-ar-white">
                    ALTARAVEN
                </a>
                <p class="text-xs text-ar-text2 mt-0.5 tracking-wider">Admin Panel</p>
            </div>

            {{-- Nav --}}
            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5">
                @php
                    $navItems = [
                        [
                            'route' => 'admin.dashboard',
                            'icon' =>
                                'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
                            'label' => 'Dashboard',
                        ],
                        [
                            'route' => 'admin.band-info.edit',
                            'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                            'label' => 'Band Info',
                        ],
                        [
                            'route' => 'admin.gallery.index',
                            'icon' =>
                                'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z',
                            'label' => 'Gallery',
                        ],
                        [
                            'route' => 'admin.members.index',
                            'icon' =>
                                'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0',
                            'label' => 'Members',
                        ],
                        [
                            'route' => 'admin.music.index',
                            'icon' =>
                                'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3',
                            'label' => 'Music',
                        ],
                        [
                            'route' => 'admin.events.index',
                            'icon' =>
                                'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                            'label' => 'Events',
                        ],
                        [
                            'route' => 'admin.products.index',
                            'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z',
                            'label' => 'Products',
                        ],
                        [
                            'route' => 'admin.orders.index',
                            'icon' =>
                                'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
                            'label' => 'Orders',
                        ],
                        [
                            'route' => 'admin.chats.index',
                            'icon' =>
                                'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z',
                            'label' => 'Chats',
                        ],
                        [
                            'route' => 'admin.contact-messages.index',
                            'icon' =>
                                'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                            'label' => 'Messages',
                        ],
                    ];
                @endphp

                @foreach ($navItems as $item)
                    <a href="{{ route($item['route']) }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded text-sm transition-colors duration-150
                        {{ request()->routeIs($item['route']) || request()->routeIs($item['route'] . '.*')
                            ? 'bg-ar-red/10 text-ar-red border-l-2 border-ar-red'
                            : 'text-ar-text2 hover:bg-ar-gray hover:text-ar-white border-l-2 border-transparent' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="{{ $item['icon'] }}" />
                        </svg>
                        {{ $item['label'] }}

                        {{-- Unread badge --}}
                        @if ($item['route'] === 'admin.contact-messages.index')
                            @php $unread = \App\Models\ContactMessage::where('is_read',false)->count(); @endphp
                            @if ($unread)
                                <span
                                    class="ml-auto bg-ar-red text-white text-xs px-1.5 py-0.5 rounded-full">{{ $unread }}</span>
                            @endif
                        @endif
                        @if ($item['route'] === 'admin.chats.index')
                            @php $activeChats = \App\Models\ChatRoom::where('status','open')->count(); @endphp
                            @if ($activeChats)
                                <span
                                    class="ml-auto bg-green-700 text-white text-xs px-1.5 py-0.5 rounded-full">{{ $activeChats }}</span>
                            @endif
                        @endif
                    </a>
                @endforeach
            </nav>

            {{-- User + logout --}}
            <div class="border-t border-ar-border px-4 py-4">
                <div class="flex items-center gap-3">
                    <div
                        class="w-8 h-8 bg-ar-red rounded-full flex items-center justify-center text-white text-xs font-bold">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-ar-white truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-ar-text2 truncate">{{ auth()->user()->email ?? '' }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-ar-text2 hover:text-ar-red transition-colors" title="Logout">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Overlay for mobile sidebar --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-black/60 lg:hidden"></div>

        {{-- ── MAIN AREA ── --}}
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- Top bar --}}
            <header class="bg-ar-dark border-b border-ar-border px-4 sm:px-6 py-4 flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-ar-text2 hover:text-ar-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h1 class="text-lg font-semibold text-ar-white">@yield('title', 'Dashboard')</h1>
                <div class="ml-auto flex items-center gap-3">
                    <a href="{{ route('home') }}" target="_blank"
                        class="text-xs text-ar-text2 hover:text-ar-white flex items-center gap-1.5 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        View Site
                    </a>
                </div>
            </header>

            {{-- Flash --}}
            @if (session('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
                    class="mx-4 sm:mx-6 mt-4 bg-green-900/50 border border-green-700 text-green-300 px-4 py-3 rounded text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
                    class="mx-4 sm:mx-6 mt-4 bg-red-900/50 border border-ar-red text-red-300 px-4 py-3 rounded text-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Page Content --}}
            <main class="flex-1 overflow-y-auto px-4 sm:px-6 py-6">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
