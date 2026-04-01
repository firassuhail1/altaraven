@extends('layouts.app')
@section('title', 'Gallery')

@section('content')

    <section style="padding-top:120px; padding-bottom:48px; background:#0f0f0f; border-bottom:1px solid #2f2f2f;">
        <div style="max-width:1280px; margin:0 auto; padding:0 32px;">
            <p style="color:#c0392b; font-size:10px; letter-spacing:0.45em; text-transform:uppercase; margin:0 0 10px;">
                Visual Universe</p>
            <h1
                style="font-family:'Bebas Neue',Impact,sans-serif; font-size:clamp(3rem,8vw,6rem); color:#f0ede8; letter-spacing:0.04em; margin:0; line-height:1;">
                Gallery</h1>
            <p style="color:#9a9994; font-size:14px; margin:12px 0 0;">{{ $items->total() }} artworks</p>
        </div>
    </section>

    <section style="max-width:1440px; margin:0 auto; padding:48px 24px 96px;">

        @forelse($items as $item)
            @if ($loop->first)
                <div style="columns:3 280px; gap:6px; column-fill:balance;">
            @endif

            <div style="break-inside:avoid; margin-bottom:6px; position:relative; overflow:hidden; background:#0f0f0f; cursor:pointer;"
                onclick="openLightbox('{{ $item->image_url }}','{{ addslashes($item->title ?? '') }}')"
                onmouseover="this.querySelector('.go').style.opacity='1'; this.querySelector('img').style.transform='scale(1.05)';"
                onmouseout="this.querySelector('.go').style.opacity='0'; this.querySelector('img').style.transform='scale(1)';">
                <img src="{{ $item->image_url }}" alt="{{ $item->title }}"
                    style="width:100%; display:block; transition:transform 0.5s ease;">
                <div class="go"
                    style="position:absolute; inset:0; background:linear-gradient(to top,rgba(8,8,8,0.85) 0%,transparent 50%); opacity:0; transition:opacity 0.3s; display:flex; align-items:flex-end; padding:16px;">
                    @if ($item->title)
                        <p style="color:#f0ede8; font-size:14px; font-weight:500; margin:0;">{{ $item->title }}</p>
                    @endif
                </div>
            </div>

            @if ($loop->last)
                </div>
            @endif

        @empty
            <div style="text-align:center; padding:96px 0;">
                <p style="color:#9a9994;">No artwork uploaded yet.</p>
            </div>
        @endforelse

        {{-- Pagination --}}
        @if ($items->hasPages())
            <div style="display:flex; justify-content:center; gap:6px; margin-top:48px; flex-wrap:wrap;">
                @if ($items->onFirstPage())
                    <span style="padding:10px 18px; color:#2f2f2f; border:1px solid #1a1a1a; font-size:12px;">← Prev</span>
                @else
                    <a href="{{ $items->previousPageUrl() }}"
                        style="padding:10px 18px; color:#9a9994; border:1px solid #2f2f2f; font-size:12px; text-decoration:none;">←
                        Prev</a>
                @endif

                @foreach ($items->getUrlRange(1, $items->lastPage()) as $page => $url)
                    <a href="{{ $url }}"
                        style="padding:10px 14px; font-size:12px; text-decoration:none; {{ $page == $items->currentPage() ? 'background:#c0392b; color:#fff; border:1px solid #c0392b;' : 'color:#9a9994; border:1px solid #2f2f2f;' }}">{{ $page }}</a>
                @endforeach

                @if ($items->hasMorePages())
                    <a href="{{ $items->nextPageUrl() }}"
                        style="padding:10px 18px; color:#9a9994; border:1px solid #2f2f2f; font-size:12px; text-decoration:none;">Next
                        →</a>
                @else
                    <span style="padding:10px 18px; color:#2f2f2f; border:1px solid #1a1a1a; font-size:12px;">Next →</span>
                @endif
            </div>
        @endif
    </section>

    {{-- Lightbox --}}
    <div id="lightbox"
        style="display:none; position:fixed; inset:0; z-index:1000; background:rgba(0,0,0,0.95); align-items:center; justify-content:center; padding:24px;"
        onclick="if(event.target===this)closeLightbox()">
        <button onclick="closeLightbox()"
            style="position:absolute; top:20px; right:24px; background:none; border:none; color:#9a9994; font-size:28px; cursor:pointer; line-height:1;">✕</button>
        <div style="max-width:900px; width:100%; text-align:center;">
            <img id="lb-img" src="" alt=""
                style="max-width:100%; max-height:80vh; object-fit:contain; display:block; margin:0 auto;">
            <p id="lb-title" style="color:#f0ede8; font-size:15px; margin:16px 0 0;"></p>
        </div>
    </div>

    <script>
        function openLightbox(src, title) {
            document.getElementById('lb-img').src = src;
            document.getElementById('lb-title').textContent = title || '';
            document.getElementById('lightbox').style.display = 'flex';
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
