@extends('layouts.app')
@section('title', 'ALTARAVEN')
@section('meta_description', 'ALTARAVEN — Official Band Website. Dark Metal. Unapologetic.')

@section('content')

    {{-- ═════════════════ LAYER 1 — HERO (pinned, full viewport) ═════════════════ --}}
    <div id="parallax-root" style="position:relative;">

        <section id="hero"
            style="
    position: sticky;
    top: 0;
    height: 100vh;
    overflow: hidden;
    z-index: 1;
">
            {{-- Sky / deep background --}}
            <div id="layer-sky"
                style="
        position:absolute; inset:0;
        background: radial-gradient(ellipse at 50% 80%, #1a0505 0%, #080808 60%);
        z-index:1;
    ">
            </div>

            {{-- Fog / atmosphere layer --}}
            <div id="layer-fog"
                style="
        position:absolute; inset:0; z-index:2;
        background: linear-gradient(to bottom, transparent 30%, rgba(192,57,43,0.04) 70%, rgba(8,8,8,0.8) 100%);
        transform-origin: bottom center;
    ">
            </div>

            {{-- Far mountain - slowest --}}
            <div id="layer-far" style="position:absolute; bottom:0; left:0; right:0; z-index:3; line-height:0;">
                <svg viewBox="0 0 1440 320" preserveAspectRatio="none" style="width:100%; height:300px; display:block;">
                    <path
                        d="M0,320 L0,180 L120,90 L240,140 L360,60 L480,110 L600,40 L720,100 L840,50 L960,120 L1080,70 L1200,130 L1320,80 L1440,140 L1440,320 Z"
                        fill="rgba(20,5,5,0.9)" />
                </svg>
            </div>

            {{-- Mid mountain --}}
            <div id="layer-mid" style="position:absolute; bottom:0; left:0; right:0; z-index:4; line-height:0;">
                <svg viewBox="0 0 1440 260" preserveAspectRatio="none" style="width:100%; height:240px; display:block;">
                    <path d="M0,260 L0,180 L200,100 L400,160 L600,80 L800,140 L1000,70 L1200,130 L1440,90 L1440,260 Z"
                        fill="rgba(12,3,3,0.95)" />
                </svg>
            </div>

            {{-- Near mountain - fastest (closest) --}}
            <div id="layer-near" style="position:absolute; bottom:0; left:0; right:0; z-index:5; line-height:0;">
                <svg viewBox="0 0 1440 200" preserveAspectRatio="none" style="width:100%; height:200px; display:block;">
                    <path d="M0,200 L0,160 L300,80 L600,140 L900,60 L1200,120 L1440,80 L1440,200 Z" fill="#080808" />
                </svg>
            </div>

            {{-- Red glow behind mountains --}}
            <div id="layer-glow"
                style="
        position:absolute; bottom:80px; left:50%; transform:translateX(-50%);
        width:700px; height:160px; z-index:2;
        background: radial-gradient(ellipse, rgba(192,57,43,0.35) 0%, transparent 70%);
        filter: blur(20px);
    ">
            </div>

            {{-- Band name --}}
            <div id="hero-title"
                style="
        position:absolute; inset:0; z-index:6;
        display:flex; flex-direction:column; align-items:center; justify-content:center;
        text-align:center; padding:0 16px;
        padding-bottom:120px;
    ">
                <p id="hero-genre"
                    style="
            color:#c0392b; font-size:10px; letter-spacing:0.55em;
            text-transform:uppercase; font-weight:500; margin:0 0 20px;
            opacity:0; animation: fadeUp 0.7s ease 0.3s forwards;
        ">
                    {{ $bandInfo->genre ?? 'Metal' }}&nbsp;&nbsp;·&nbsp;&nbsp;{{ $bandInfo->origin ?? 'Indonesia' }}</p>

                <h1
                    style="
            font-family:'Bebas Neue',Impact,sans-serif;
            font-size:clamp(5rem,17vw,13rem);
            line-height:0.9; color:#f0ede8;
            letter-spacing:0.04em; margin:0 0 20px;
            text-shadow: 0 0 120px rgba(192,57,43,0.2);
            opacity:0; animation: fadeUp 0.9s ease 0.5s forwards;
        ">
                    ALTARAVEN</h1>

                @if ($bandInfo->tagline)
                    <p
                        style="
            font-size:clamp(0.85rem,1.8vw,1.1rem); font-weight:300;
            letter-spacing:0.12em; color:#9a9994;
            max-width:480px; margin:0 0 40px;
            opacity:0; animation: fadeUp 0.9s ease 0.7s forwards;
        ">
                        {{ $bandInfo->tagline }}</p>
                @endif

                <div
                    style="
            display:flex; gap:12px; flex-wrap:wrap; justify-content:center;
            opacity:0; animation: fadeUp 0.9s ease 0.9s forwards;
        ">
                    <a href="{{ route('music.index') }}" class="cta-red">Play Music</a>
                    <a href="{{ route('merch.index') }}" class="cta-ghost">View Merch</a>
                </div>
            </div>

            {{-- Scroll cue --}}
            <div id="scroll-cue"
                style="
        position:absolute; bottom:32px; left:50%; transform:translateX(-50%);
        z-index:10; text-align:center;
        opacity:0; animation: fadeIn 1s ease 1.4s forwards;
    ">
                <div
                    style="font-size:9px; letter-spacing:0.5em; text-transform:uppercase; color:#9a9994; margin-bottom:10px;">
                    Scroll to Explore
                </div>
                <div
                    style="width:1px; height:48px; background:linear-gradient(to bottom,#c0392b,transparent); margin:0 auto;
                    animation: lineGrow 2s ease-in-out infinite;">
                </div>
            </div>
        </section>

        {{-- ════════════════════════ LAYER 2 — ART GALLERY ══════════════════════════ --}}
        <section id="art-section"
            style="position:relative; z-index:10; background:#080808; padding:80px 0 0; margin-top:-1px;">

            {{-- Section intro --}}
            <div style="max-width:1280px; margin:0 auto; padding:0 32px 64px;" class="reveal-up">
                <div class="gallery-header">
                    <div>
                        <p
                            style="color:#c0392b; font-size:10px; letter-spacing:0.45em; text-transform:uppercase; margin:0 0 10px;">
                            Visual Universe</p>
                        <h2
                            style="font-family:'Bebas Neue',Impact,sans-serif; font-size:clamp(2.5rem,6vw,5rem); color:#f0ede8; letter-spacing:0.04em; margin:0; line-height:1;">
                            The Art of<br>ALTARAVEN
                        </h2>
                    </div>
                    <p class="gallery-subtitle">
                        Darkness rendered visible. The visual language of our music.
                    </p>
                </div>
                <div style="width:60px; height:2px; background:#c0392b;"></div>
            </div>

            {{-- GALLERY GRID --}}
            <div id="gallery-grid">

                @php
                    $slots = [
                        ['class' => 'gi-feature', 'delay' => 0, 'label' => 'Feature Art', 'overlay' => 'Main Visual'],
                        ['class' => 'gi-sm', 'delay' => 100, 'label' => 'Art 02', 'overlay' => 'Secondary'],
                        ['class' => 'gi-sm', 'delay' => 150, 'label' => 'Art 03', 'overlay' => 'Artwork'],
                        ['class' => 'gi-sm', 'delay' => 200, 'label' => 'Art 04', 'overlay' => 'Artwork'],
                        ['class' => 'gi-sm', 'delay' => 250, 'label' => 'Art 05', 'overlay' => 'Artwork'],
                        ['class' => 'gi-wide', 'delay' => 300, 'label' => 'Wide Banner', 'overlay' => 'Banner'],
                        ['class' => 'gi-sm', 'delay' => 350, 'label' => 'Art 07', 'overlay' => 'Artwork'],
                    ];
                @endphp

                @foreach ($slots as $i => $slot)
                    @php $item = $galleryItems->get($i); @endphp
                    <div class="gallery-item {{ $slot['class'] }}" data-delay="{{ $slot['delay'] }}"
                        @if ($item) onclick="openLightbox('{{ $item->image_url }}','{{ addslashes($item->title ?? '') }}')" style="cursor:pointer;" @endif>

                        @if ($item)
                            <img src="{{ $item->image_url }}" alt="{{ $item->title ?? $slot['label'] }}"
                                style="width:100%; height:100%; object-fit:cover; display:block; transition:transform 0.6s ease;">
                        @else
                            <div class="gallery-placeholder"
                                style="width:100%; height:100%; min-height:240px; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:8px;">
                                @if ($i === 0)
                                    <svg width="28" height="28" fill="none" stroke="#2f2f2f" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                @endif
                                <p
                                    style="color:#2f2f2f; font-size:10px; letter-spacing:0.3em; text-transform:uppercase; margin:0;">
                                    {{ $slot['label'] }}</p>
                            </div>
                        @endif

                        <div class="gallery-overlay">
                            <span
                                style="font-family:'Bebas Neue',Impact,sans-serif; font-size:{{ $i === 0 || $i === 5 ? '1.5rem' : '1rem' }}; letter-spacing:0.1em; color:#f0ede8;">
                                {{ $item->title ?? $slot['overlay'] }}
                            </span>
                        </div>
                    </div>
                @endforeach

            </div>

            {{-- View All --}}
            <div style="text-align:center; padding:48px 24px 64px;">
                @php $total = \App\Models\GalleryItem::active()->count(); @endphp
                @if ($total > 7)
                    <p style="color:#9a9994; font-size:12px; letter-spacing:0.2em; margin-bottom:16px;">
                        +{{ $total - 7 }} more artworks
                    </p>
                @endif
                <a href="{{ route('gallery.index') }}"
                    style="display:inline-block; padding:13px 40px; border:1px solid #2f2f2f; color:#9a9994; font-size:12px; font-weight:600; letter-spacing:0.25em; text-transform:uppercase; text-decoration:none; transition:all 0.2s;"
                    onmouseover="this.style.borderColor='#c0392b'; this.style.color='#c0392b'"
                    onmouseout="this.style.borderColor='#2f2f2f'; this.style.color='#9a9994'">
                    View All Artwork →
                </a>
            </div>{{-- end gallery-grid --}}

            {{-- Gallery CTA --}}
            {{-- <div style="text-align:center; padding:48px 24px;" class="reveal-up">
                <p style="color:#9a9994; font-size:13px; letter-spacing:0.2em; margin-bottom:20px;">Upload your artwork via
                    Admin Panel → Band Info</p>
            </div> --}}
        </section>

        {{-- ═════════════════════ MARQUEE ════════════════════════════════ --}}
        <div
            style="overflow:hidden; border-top:1px solid #2f2f2f; border-bottom:1px solid #2f2f2f; background:#0f0f0f; padding:14px 0; position:relative; z-index:10;">
            <div style="display:flex; white-space:nowrap; animation:marquee 28s linear infinite;">
                @for ($i = 0; $i < 8; $i++)
                    <span
                        style="margin:0 32px; font-size:10px; letter-spacing:0.5em; text-transform:uppercase; color:#9a9994;">ALTARAVEN</span>
                    <span style="margin:0 8px; color:#c0392b;">✦</span>
                    <span
                        style="margin:0 32px; font-size:10px; letter-spacing:0.5em; text-transform:uppercase; color:#9a9994;">{{ $bandInfo->genre ?? 'Metal' }}</span>
                    <span style="margin:0 8px; color:#c0392b;">✦</span>
                    <span
                        style="margin:0 32px; font-size:10px; letter-spacing:0.5em; text-transform:uppercase; color:#9a9994;">{{ $bandInfo->origin ?? 'Indonesia' }}</span>
                    <span style="margin:0 8px; color:#c0392b;">✦</span>
                @endfor
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════
     LATEST RELEASE
══════════════════════════════════════════════════════ --}}
        @if ($latestRelease)
            <section class="section-inner reveal-up">
                <div class="section-header">
                    <div>
                        <p class="section-eyebrow">Latest Release</p>
                        <h2 class="section-title">New Music</h2>
                    </div>
                    <a href="{{ route('music.index') }}" class="link-muted">All Releases →</a>
                </div>
                <div class="release-grid">
                    <div style="position:relative; overflow:hidden; aspect-ratio:1;">
                        <img src="{{ $latestRelease->cover_url }}" alt="{{ $latestRelease->title }}"
                            style="width:100%; height:100%; object-fit:cover; transition:transform 0.6s; display:block;"
                            onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        <div
                            style="position:absolute; inset:0; background:linear-gradient(to top,rgba(8,8,8,0.6) 0%,transparent 50%);">
                        </div>
                        <span
                            style="position:absolute; bottom:16px; left:16px; font-size:9px; letter-spacing:0.35em; text-transform:uppercase; background:rgba(8,8,8,0.8); color:#9a9994; padding:5px 10px;">{{ strtoupper($latestRelease->type) }}</span>
                    </div>
                    <div>
                        <p
                            style="color:#9a9994; font-size:11px; letter-spacing:0.35em; text-transform:uppercase; margin:0 0 10px;">
                            {{ $latestRelease->release_year }}</p>
                        <h3
                            style="font-family:'Bebas Neue',Impact,sans-serif; font-size:clamp(2rem,4vw,3rem); color:#f0ede8; letter-spacing:0.05em; margin:0 0 16px; line-height:1;">
                            {{ $latestRelease->title }}</h3>
                        @if ($latestRelease->description)
                            <p style="color:#9a9994; line-height:1.75; margin:0 0 28px; font-size:15px;">
                                {{ $latestRelease->description }}</p>
                        @endif
                        @if ($latestRelease->spotify_embed)
                            <div style="margin-bottom:28px;">
                                <iframe src="{{ $latestRelease->spotify_embed }}" width="100%"
                                    height="{{ $latestRelease->tracks->count() > 1 ? '352' : '152' }}" frameborder="0"
                                    allowfullscreen=""
                                    allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
                                    loading="lazy"></iframe>
                            </div>
                        @endif
                        <a href="{{ route('music.show', $latestRelease->slug) }}" class="link-red">View Album →</a>
                    </div>
                </div>
            </section>
        @endif

        {{-- ══════════════════════════════════════════════════════
     UPCOMING EVENT
══════════════════════════════════════════════════════ --}}
        @if ($upcomingEvent)
            <section class="event-section reveal-up">
                <div class="section-inner">
                    <div class="event-grid">
                        <div>
                            <p class="section-eyebrow">Next Show</p>
                            <h2 class="section-title">{{ $upcomingEvent->name }}</h2>
                            <div class="event-meta">
                                <span>📅 {{ $upcomingEvent->event_date->translatedFormat('d F Y') }}</span>
                                <span>📍
                                    {{ $upcomingEvent->venue ? $upcomingEvent->venue . ', ' : '' }}{{ $upcomingEvent->city }}</span>
                            </div>
                            <div style="display:flex; gap:16px; flex-wrap:wrap;">
                                @if ($upcomingEvent->ticket_url)
                                    <a href="{{ $upcomingEvent->ticket_url }}" target="_blank" class="cta-red">Get
                                        Tickets</a>
                                @endif
                                <a href="{{ route('events.index') }}" class="cta-ghost">All Events</a>
                            </div>
                        </div>
                        @if ($upcomingEvent->poster_image)
                            <div style="overflow:hidden; max-height:300px;">
                                <img src="{{ $upcomingEvent->poster_url }}" alt="{{ $upcomingEvent->name }}"
                                    style="width:100%; object-fit:cover; opacity:0.75; transition:transform 0.6s;"
                                    onmouseover="this.style.transform='scale(1.03)'"
                                    onmouseout="this.style.transform='scale(1)'">
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        @endif

        {{-- ══════════════════════════════════════════════════════
     FEATURED MERCH
══════════════════════════════════════════════════════ --}}
        @if ($featuredMerch->count())
            <section class="section-inner reveal-up">
                <div class="section-header">
                    <div>
                        <p class="section-eyebrow">Official Store</p>
                        <h2 class="section-title">Featured Merch</h2>
                    </div>
                    <a href="{{ route('merch.index') }}" class="link-muted">All Products →</a>
                </div>
                <div class="merch-grid">
                    @foreach ($featuredMerch as $product)
                        <a href="{{ route('merch.show', $product->slug) }}" class="merch-card"
                            style="text-decoration:none; display:block;">
                            <div style="overflow:hidden; aspect-ratio:1; background:#1a1a1a; margin-bottom:16px;">
                                <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}"
                                    style="width:100%; height:100%; object-fit:cover; transition:transform 0.6s; display:block;">
                            </div>
                            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                                <div>
                                    <h3 class="merch-title"
                                        style="font-weight:500; font-size:15px; color:#f0ede8; margin:0 0 4px; transition:color 0.2s;">
                                        {{ $product->name }}</h3>
                                    <p
                                        style="font-size:11px; color:#9a9994; text-transform:uppercase; letter-spacing:0.15em; margin:0;">
                                        {{ $product->category }}</p>
                                </div>
                                <p style="color:#c0392b; font-weight:600; font-size:14px; white-space:nowrap; margin:0;">
                                    {{ $product->formatted_price }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

    </div>{{-- end parallax-root --}}

    {{-- Lightbox --}}
    <div id="lightbox"
        style="display:none; position:fixed; inset:0; z-index:1000; background:rgba(0,0,0,0.95); align-items:center; justify-content:center; padding:24px;"
        onclick="if(event.target===this)closeLightbox()">
        <button onclick="closeLightbox()"
            style="position:absolute; top:20px; right:24px; background:none; border:none; color:#9a9994; font-size:28px; cursor:pointer;">✕</button>
        <div style="max-width:900px; width:100%; text-align:center;">
            <img id="lb-img" src="" alt=""
                style="max-width:100%; max-height:80vh; object-fit:contain; display:block; margin:0 auto;">
            <p id="lb-title" style="color:#f0ede8; font-size:15px; margin-top:16px;"></p>
        </div>
    </div>

    {{-- ══════════════════════════════ STYLES ════════════════════════════════════ --}}
    <style>
        /* ── Animations ── */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(28px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0
            }

            to {
                opacity: 1
            }
        }

        @keyframes marquee {
            from {
                transform: translateX(0)
            }

            to {
                transform: translateX(-50%)
            }
        }

        @keyframes lineGrow {

            0%,
            100% {
                transform: scaleY(1);
                opacity: 1;
            }

            50% {
                transform: scaleY(1.4);
                opacity: 0.5;
            }
        }

        /* ── CTA buttons ── */
        .cta-red {
            display: inline-block;
            padding: 13px 30px;
            background: #c0392b;
            color: #fff;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            text-decoration: none;
            transition: background 0.2s;
        }

        .cta-red:hover {
            background: #e74c3c;
        }

        .cta-ghost {
            display: inline-block;
            padding: 13px 30px;
            border: 1px solid #2f2f2f;
            color: #9a9994;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            text-decoration: none;
            transition: border-color 0.2s, color 0.2s;
        }

        .cta-ghost:hover {
            border-color: #9a9994;
            color: #f0ede8;
        }

        .link-red {
            font-size: 13px;
            font-weight: 600;
            color: #c0392b;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            text-decoration: none;
        }

        .link-red:hover {
            color: #e74c3c;
        }

        .link-muted {
            font-size: 12px;
            color: #9a9994;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            text-decoration: none;
        }

        .link-muted:hover {
            color: #f0ede8;
        }

        /* ── Section helpers ── */
        .section-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 96px 32px;
            position: relative;
            z-index: 10;
        }

        .section-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 56px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .section-eyebrow {
            color: #c0392b;
            font-size: 10px;
            letter-spacing: 0.45em;
            text-transform: uppercase;
            margin: 0 0 10px;
        }

        .section-title {
            font-family: 'Bebas Neue', Impact, sans-serif;
            font-size: clamp(2.5rem, 5vw, 4rem);
            color: #f0ede8;
            letter-spacing: 0.05em;
            margin: 0;
            line-height: 1;
        }

        /* ── Gallery header ── */
        .gallery-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 16px;
        }

        .gallery-subtitle {
            color: #9a9994;
            font-size: 14px;
            max-width: 300px;
            line-height: 1.7;
            text-align: right;
            margin: 0;
        }

        /* ══════════════════════════════════════════════════
                                                                                   GALLERY GRID — CSS class-based (no inline style override)
                                                                                ══════════════════════════════════════════════════ */
        #gallery-grid {
            max-width: 1440px;
            margin: 0 auto;
            padding: 0 24px;
            display: grid;
            gap: 4px;
            /* Desktop: 3 columns */
            grid-template-columns: 2fr 1fr 1fr;
        }

        /* Feature item spans 2 rows on desktop */
        .gi-feature {
            grid-row: span 2;
        }

        /* Wide item spans 2 columns on desktop */
        .gi-wide {
            grid-column: span 2;
        }

        /* All items share base styles */
        .gallery-item {
            position: relative;
            overflow: hidden;
            background: #0f0f0f;
            cursor: pointer;
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.6s ease, transform 0.6s ease;
            min-height: 244px;
        }

        .gi-feature {
            min-height: 500px;
        }

        .gi-wide {
            min-height: 220px;
        }

        .gallery-item.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
            display: block;
        }

        .gallery-item:hover img {
            transform: scale(1.06);
        }

        /* Placeholder */
        .gallery-placeholder {
            width: 100%;
            height: 100%;
            min-height: inherit;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 12px;
            background: repeating-linear-gradient(45deg,
                    #0c0c0c 0px, #0c0c0c 10px,
                    #0f0f0f 10px, #0f0f0f 20px);
        }

        .gallery-placeholder-icon {
            width: 48px;
            height: 48px;
            border: 1px solid #2f2f2f;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .gallery-placeholder-label {
            color: #2f2f2f;
            font-size: 11px;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            margin: 0;
        }

        .gallery-placeholder-sub {
            color: #2f2f2f;
            font-size: 10px;
            margin: 0;
        }

        /* Overlay */
        .gallery-overlay {
            position: absolute;
            inset: 0;
            z-index: 2;
            background: linear-gradient(to top, rgba(8, 8, 8, 0.85) 0%, transparent 50%);
            opacity: 0;
            transition: opacity 0.3s;
            display: flex;
            align-items: flex-end;
            padding: 20px;
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }

        .gallery-overlay-title {
            font-family: 'Bebas Neue', Impact, sans-serif;
            font-size: 1.5rem;
            letter-spacing: 0.1em;
            color: #f0ede8;
        }

        .gallery-overlay-sub {
            font-size: 13px;
            color: #f0ede8;
            letter-spacing: 0.1em;
        }

        /* ── Release grid ── */
        .release-grid {
            display: grid;
            grid-template-columns: 1fr 1.4fr;
            gap: 56px;
            align-items: center;
        }

        /* ── Event section ── */
        .event-section {
            background: #0f0f0f;
            border-top: 1px solid #2f2f2f;
            border-bottom: 1px solid #2f2f2f;
            padding: 72px 0;
            position: relative;
            z-index: 10;
        }

        .event-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 56px;
            align-items: center;
        }

        .event-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 24px;
            font-size: 14px;
            color: #9a9994;
            margin-bottom: 28px;
        }

        /* ── Merch grid ── */
        .merch-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
        }

        /* ── Merch card ── */
        .merch-card:hover .merch-title {
            color: #c0392b;
        }

        .merch-card:hover img {
            transform: scale(1.05);
        }

        /* ── Scroll reveal ── */
        .reveal-up {
            opacity: 0;
            transform: translateY(48px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        .reveal-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ══════════════════════════════════════════════════
                                                                                   RESPONSIVE
                                                                                ══════════════════════════════════════════════════ */

        /* Tablet: 641px – 900px */
        @media (max-width: 900px) {
            #gallery-grid {
                grid-template-columns: 1fr 1fr;
            }

            .gi-feature {
                grid-column: span 2;
                grid-row: span 1;
                min-height: 280px;
            }

            .gi-wide {
                grid-column: span 2;
            }

            .release-grid {
                grid-template-columns: 1fr;
                gap: 32px;
            }

            .event-grid {
                grid-template-columns: 1fr;
                gap: 32px;
            }

            .merch-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .gallery-subtitle {
                text-align: left;
            }
        }

        /* Mobile: ≤ 640px */
        @media (max-width: 640px) {
            #gallery-grid {
                grid-template-columns: 2fr;
                padding: 0 16px;
            }

            .gi-feature,
            .gi-wide {
                grid-column: span 1;
                grid-row: span 1;
            }

            .gi-feature {
                min-height: 240px;
            }

            .gi-wide {
                min-height: 200px;
            }

            .gallery-item {
                min-height: 200px;
            }

            .section-inner {
                padding: 64px 20px;
            }

            .section-header {
                flex-direction: column;
                align-items: flex-start;
                margin-bottom: 32px;
            }

            .gallery-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .gallery-subtitle {
                text-align: left;
                max-width: 100%;
            }

            .release-grid {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .event-grid {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .merch-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .cta-red,
            .cta-ghost {
                padding: 12px 20px;
                font-size: 11px;
            }
        }
    </style>

    {{-- ═════════════════ PARALLAX + INTERACTION SCRIPTS ══════════════════════════ --}}
    <script>
        (function() {
            var hero = document.getElementById('hero');
            var layerFar = document.getElementById('layer-far');
            var layerMid = document.getElementById('layer-mid');
            var layerNear = document.getElementById('layer-near');
            var layerGlow = document.getElementById('layer-glow');
            var layerFog = document.getElementById('layer-fog');
            var heroTitle = document.getElementById('hero-title');
            var scrollCue = document.getElementById('scroll-cue');
            var ticking = false;

            function onScroll() {
                if (!ticking) {
                    window.requestAnimationFrame(function() {
                        var s = window.scrollY;
                        var vh = window.innerHeight;

                        if (layerFar) layerFar.style.transform = 'translateY(' + (s * -0.08) + 'px)';
                        if (layerMid) layerMid.style.transform = 'translateY(' + (s * -0.18) + 'px)';
                        if (layerNear) layerNear.style.transform = 'translateY(' + (s * -0.30) + 'px)';
                        if (layerGlow) layerGlow.style.transform = 'translateX(-50%) translateY(' + (s * -
                            0.22) + 'px)';
                        if (layerFog) layerFog.style.transform = 'scaleY(' + (1 + s * 0.0003) + ')';

                        if (heroTitle) {
                            var progress = Math.min(s / (vh * 0.6), 1);
                            heroTitle.style.transform = 'translateY(' + (s * -0.25) + 'px)';
                            heroTitle.style.opacity = 1 - progress * 1.4;
                        }

                        if (scrollCue) {
                            scrollCue.style.opacity = s > 60 ? '0' : '1';
                            scrollCue.style.transition = 'opacity 0.4s';
                        }

                        ticking = false;
                    });
                    ticking = true;
                }
            }

            window.addEventListener('scroll', onScroll, {
                passive: true
            });
            onScroll();

            var cue = document.getElementById('scroll-cue');
            if (cue) {
                cue.style.cursor = 'pointer';
                cue.addEventListener('click', function() {
                    document.getElementById('art-section')?.scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            }

            var revealEls = document.querySelectorAll('.reveal-up, .gallery-item');
            if ('IntersectionObserver' in window) {
                var io = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            var el = entry.target;
                            var delay = el.dataset.delay || 0;
                            setTimeout(function() {
                                el.classList.add('visible');
                            }, parseInt(delay));
                            io.unobserve(el);
                        }
                    });
                }, {
                    threshold: 0.1
                });
                revealEls.forEach(function(el) {
                    io.observe(el);
                });
            } else {
                revealEls.forEach(function(el) {
                    el.classList.add('visible');
                });
            }
        })();
    </script>

    <script>
        function openLightbox(src, title) {
            document.getElementById('lb-img').src = src;
            document.getElementById('lb-title').textContent = title || '';
            var lb = document.getElementById('lightbox');
            lb.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            document.getElementById('lightbox').style.display = 'none';
            document.body.style.overflow = '';
        }
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeLightbox();
        });
    </script>

@endsection
