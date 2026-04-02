<!DOCTYPE html>
<html lang="id" style="scroll-behavior: smooth;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ALTARAVEN') | Official Website</title>
    <meta name="description" content="@yield('meta_description', 'ALTARAVEN — Official Band Website.')">

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Hard-coded fallbacks — always apply regardless of Tailwind */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            background-color: #080808;
            color: #e8e6e1;
            font-family: 'Barlow', system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        .font-display {
            font-family: 'Bebas Neue', Impact, sans-serif;
        }

        /* Nav */
        #main-nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
            transition: background 0.3s, border-color 0.3s;
        }

        #main-nav.scrolled {
            background: rgba(8, 8, 8, 0.96);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid #2f2f2f;
        }

        .nav-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 72px;
        }

        .nav-logo {
            font-family: 'Bebas Neue', Impact, sans-serif;
            font-size: 1.75rem;
            letter-spacing: 0.2em;
            color: #f0ede8;
            text-decoration: none;
            transition: color 0.2s;
        }

        .nav-logo:hover {
            color: #c0392b;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 32px;
        }

        .nav-link {
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: #9a9994;
            text-decoration: none;
            transition: color 0.2s;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #c0392b;
        }

        .nav-cart {
            position: relative;
            color: #9a9994;
            text-decoration: none;
            transition: color 0.2s;
        }

        .nav-cart:hover {
            color: #f0ede8;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #c0392b;
            color: white;
            font-size: 10px;
            font-weight: 700;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Mobile nav */
        .nav-burger {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            color: #9a9994;
            padding: 4px;
        }

        .mobile-menu {
            display: none;
            background: #0f0f0f;
            border-top: 1px solid #2f2f2f;
            padding: 16px 24px;
        }

        .mobile-menu.open {
            display: block;
        }

        .mobile-menu a {
            display: block;
            padding: 12px 0;
            font-size: 13px;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: #9a9994;
            text-decoration: none;
            border-bottom: 1px solid #1a1a1a;
        }

        .mobile-menu a:hover {
            color: #c0392b;
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .nav-burger {
                display: block;
            }
        }

        /* Flash messages */
        .flash-msg {
            position: fixed;
            top: 88px;
            right: 16px;
            z-index: 100;
            padding: 12px 20px;
            font-size: 13px;
            border-radius: 2px;
            max-width: 320px;
            animation: fadeIn 0.3s ease;
        }

        .flash-success {
            background: rgba(6, 78, 59, 0.9);
            border: 1px solid #065f46;
            color: #a7f3d0;
        }

        .flash-error {
            background: rgba(127, 29, 29, 0.9);
            border: 1px solid #991b1b;
            color: #fca5a5;
        }

        /* Footer */
        .site-footer {
            background: #0f0f0f;
            border-top: 1px solid #2f2f2f;
            margin-top: 96px;
            padding: 64px 24px 32px;
        }

        .footer-inner {
            max-width: 1280px;
            margin: 0 auto;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 48px;
            margin-bottom: 48px;
        }

        @media (max-width: 768px) {
            .footer-grid {
                grid-template-columns: 1fr;
                gap: 32px;
            }
        }

        .footer-bottom {
            border-top: 1px solid #2f2f2f;
            padding-top: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateX(-50%) translateY(0);
            }

            50% {
                transform: translateX(-50%) translateY(-10px);
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    {{-- ── NAV ── --}}
    <nav id="main-nav">
        <div class="nav-inner">
            <a href="{{ route('home') }}" class="nav-logo">ALTARAVEN</a>

            <div class="nav-links">
                @php
                    $navItems = [
                        ['route' => 'home', 'label' => 'Home'],
                        ['route' => 'about', 'label' => 'About'],
                        ['route' => 'gallery.index', 'label' => 'Gallery'],
                        ['route' => 'music.index', 'label' => 'Music'],
                        ['route' => 'events.index', 'label' => 'Events'],
                        ['route' => 'merch.index', 'label' => 'Merch'],
                        ['route' => 'contact.index', 'label' => 'Contact'],
                    ];
                @endphp
                @foreach ($navItems as $item)
                    <a href="{{ route($item['route']) }}"
                        class="nav-link {{ request()->routeIs($item['route']) ? 'active' : '' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach

                @php $cartCount = app(\App\Services\CartService::class)->count(); @endphp
                <a href="{{ route('cart.index') }}" class="nav-cart">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    @if ($cartCount > 0)
                        <span class="cart-badge">{{ $cartCount }}</span>
                    @endif
                </a>
            </div>

            {{-- Mobile burger --}}
            <button class="nav-burger" onclick="document.getElementById('mobile-menu').classList.toggle('open')"
                aria-label="Menu">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        {{-- Mobile menu --}}
        <div id="mobile-menu" class="mobile-menu">
            @foreach ($navItems as $item)
                <a href="{{ route($item['route']) }}">{{ $item['label'] }}</a>
            @endforeach
            <a href="{{ route('cart.index') }}">Cart @if ($cartCount > 0)
                    ({{ $cartCount }})
                @endif
            </a>
        </div>
    </nav>

    {{-- Flash --}}
    @if (session('success'))
        <div class="flash-msg flash-success" onclick="this.remove()">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="flash-msg flash-error" onclick="this.remove()">{{ session('error') }}</div>
    @endif

    {{-- Main --}}
    <main>@yield('content')</main>

    {{-- Footer --}}
    <footer class="site-footer">
        @php $bandInfo = \App\Models\BandInfo::getInstance(); @endphp
        <div class="footer-inner">
            <div class="footer-grid">
                <div>
                    <div class="font-display"
                        style="font-size:2rem; letter-spacing:0.2em; color:#f0ede8; margin-bottom:12px;">ALTARAVEN</div>
                    <p style="color:#9a9994; font-size:14px; line-height:1.7; max-width:300px;">
                        {{ $bandInfo->tagline }}</p>
                    @if ($bandInfo->social_links)
                        <div style="display:flex; gap:16px; margin-top:20px; flex-wrap:wrap;">
                            @foreach ($bandInfo->social_links as $platform => $url)
                                @if ($url)
                                    <a href="{{ $url }}" target="_blank" rel="noopener"
                                        style="font-size:11px; letter-spacing:0.2em; text-transform:uppercase; color:#9a9994; text-decoration:none;"
                                        onmouseover="this.style.color='#c0392b'"
                                        onmouseout="this.style.color='#9a9994'">
                                        {{ $platform }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
                <div>
                    <p
                        style="font-size:11px; letter-spacing:0.3em; text-transform:uppercase; color:#9a9994; margin-bottom:16px;">
                        Navigate</p>
                    @foreach ($navItems as $item)
                        <a href="{{ route($item['route']) }}"
                            style="display:block; font-size:13px; color:#9a9994; text-decoration:none; margin-bottom:8px;"
                            onmouseover="this.style.color='#f0ede8'" onmouseout="this.style.color='#9a9994'">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>
                <div>
                    <p
                        style="font-size:11px; letter-spacing:0.3em; text-transform:uppercase; color:#9a9994; margin-bottom:16px;">
                        Contact</p>
                    @if ($bandInfo->email)
                        <a href="mailto:{{ $bandInfo->email }}"
                            style="font-size:13px; color:#9a9994; text-decoration:none; display:block; margin-bottom:8px;"
                            onmouseover="this.style.color='#c0392b'" onmouseout="this.style.color='#9a9994'">
                            {{ $bandInfo->email }}
                        </a>
                    @endif
                    @if ($bandInfo->origin)
                        <p style="font-size:13px; color:#9a9994;">{{ $bandInfo->origin }}</p>
                    @endif
                </div>
            </div>
            <div class="footer-bottom">
                <p style="font-size:12px; color:#9a9994;">© {{ date('Y') }} ALTARAVEN. All rights reserved.</p>
                <p style="font-size:12px; color:#2f2f2f;">Made with darkness.</p>
            </div>
        </div>
    </footer>

    <script>
        // Scroll nav effect
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('main-nav');
            if (window.scrollY > 40) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });

        // Auto-hide flash messages
        setTimeout(function() {
            document.querySelectorAll('.flash-msg').forEach(function(el) {
                el.style.opacity = '0';
                el.style.transition = 'opacity 0.5s';
                setTimeout(function() {
                    el.remove();
                }, 500);
            });
        }, 4000);
    </script>

    @stack('scripts')
</body>

</html>
