@extends('layouts.admin')
@section('title', 'Gallery')

@section('content')

    @php
        $input =
            'w-full bg-[#111] border border-ar-border text-ar-white placeholder-ar-text2 px-3 py-2.5 text-sm focus:border-ar-red focus:outline-none transition-colors';
        $label = 'block text-xs tracking-widest uppercase text-ar-text2 mb-1.5';
    @endphp

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-ar-white">Gallery</h1>
            <p class="text-xs text-ar-text2 mt-0.5">Kelola foto / artwork di halaman utama. Drag untuk mengubah urutan.</p>
        </div>
        <span class="text-xs text-ar-text2 bg-ar-gray border border-ar-border px-3 py-1.5 rounded">
            {{ $items->count() }} gambar
        </span>
    </div>

    {{-- ── UPLOAD FORM ── --}}
    <div class="bg-ar-dark border border-ar-border p-6 mb-6">
        <p class="text-xs text-ar-text2 uppercase tracking-widest mb-4">Upload Gambar Baru</p>
        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                {{-- Drop zone --}}
                <div id="drop-zone"
                    class="border-2 border-dashed border-ar-border hover:border-ar-red transition-colors p-8 text-center cursor-pointer"
                    onclick="document.getElementById('gallery-file-input').click()">
                    <svg class="w-10 h-10 text-ar-text2 mx-auto mb-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-ar-text2 text-sm mb-1">Klik atau drag gambar ke sini</p>
                    <p class="text-ar-text2 text-xs">PNG, JPG, WEBP — Maks 5MB per file — Bisa pilih banyak sekaligus</p>
                    <input id="gallery-file-input" type="file" name="images[]" multiple accept="image/*" class="hidden"
                        onchange="previewImages(this)">
                </div>

                {{-- Preview area --}}
                <div id="preview-grid" class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-6 gap-3">
                    {{-- Preview items will be injected here by JS --}}
                </div>

                {{-- Title inputs (injected by JS) --}}
                <div id="title-inputs" class="space-y-2 hidden">
                    <p class="text-xs text-ar-text2 uppercase tracking-widest">Caption / Judul (opsional)</p>
                </div>

                <button id="upload-btn" type="submit"
                    class="hidden px-6 py-3 bg-ar-red hover:bg-ar-red2 text-white text-sm font-semibold tracking-widest uppercase transition-colors">
                    Upload Gambar
                </button>
            </div>
        </form>
    </div>

    {{-- ── GALLERY GRID (sortable) ── --}}
    @if ($items->count())
        <div class="bg-ar-dark border border-ar-border p-6">
            <div class="flex items-center justify-between mb-4">
                <p class="text-xs text-ar-text2 uppercase tracking-widest">Gambar Tersimpan</p>
                <p class="text-xs text-ar-text2">Drag untuk ubah urutan · Gambar pertama = Feature, ke-6 = Wide Banner</p>
            </div>

            <div id="sortable-grid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3">
                @foreach ($items as $item)
                    <div class="gallery-sort-item relative group bg-ar-gray border border-ar-border cursor-grab active:cursor-grabbing"
                        data-id="{{ $item->id }}">

                        {{-- Badge posisi --}}
                        <div class="absolute top-1.5 left-1.5 z-10">
                            <span class="text-[9px] bg-ar-black/80 text-ar-text2 px-1.5 py-0.5 tracking-widest uppercase">
                                #{{ $loop->iteration }}
                                @if ($loop->first)
                                    — Feature
                                @endif
                                @if ($loop->iteration === 6)
                                    — Wide
                                @endif
                            </span>
                        </div>

                        {{-- Active badge --}}
                        <div class="absolute top-1.5 right-1.5 z-10">
                            <span
                                class="w-2 h-2 rounded-full inline-block {{ $item->is_active ? 'bg-green-500' : 'bg-ar-text2' }}"></span>
                        </div>

                        {{-- Image --}}
                        <div class="aspect-square overflow-hidden">
                            <img src="{{ $item->image_url }}" alt="{{ $item->title }}"
                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                        </div>

                        {{-- Info & actions --}}
                        <div class="p-2">
                            <p class="text-xs text-ar-text2 truncate mb-2">{{ $item->title ?: '—' }}</p>
                            <div class="flex gap-1">
                                {{-- Edit modal trigger --}}
                                <button type="button"
                                    onclick="openEdit({{ $item->id }}, '{{ addslashes($item->title ?? '') }}', {{ $item->is_active ? 'true' : 'false' }})"
                                    class="flex-1 text-[10px] py-1 bg-ar-gray border border-ar-border text-ar-text2 hover:text-ar-white hover:border-ar-text transition-colors">
                                    Edit
                                </button>
                                {{-- Delete --}}
                                <form id="form-delete-gallery-{{ $item->id }}"
                                    action="{{ route('admin.gallery.destroy', $item) }}" method="POST"
                                    onsubmit="return confirm('Hapus gambar ini?')">
                                    @csrf @method('DELETE')
                                </form>
                                <button type="submit" form="form-delete-gallery-{{ $item->id }}"
                                    class="px-2 text-[10px] py-1 bg-ar-gray border border-ar-border text-ar-text2 hover:text-ar-red hover:border-ar-red transition-colors">
                                    ✕
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="bg-ar-dark border border-ar-border p-12 text-center">
            <p class="text-ar-text2 text-sm">Belum ada gambar. Upload di atas untuk memulai.</p>
        </div>
    @endif

    {{-- ── EDIT MODAL ── --}}
    <div id="edit-modal" class="fixed inset-0 z-50 bg-black/70 hidden items-center justify-center">
        <div class="bg-ar-dark border border-ar-border p-6 w-full max-w-sm mx-4">
            <p class="text-xs text-ar-text2 uppercase tracking-widest mb-4">Edit Gallery Item</p>
            <form id="edit-form" method="POST" class="space-y-4">
                @csrf @method('PATCH')
                <div>
                    <label class="{{ $label }}">Caption / Judul</label>
                    <input type="text" name="title" id="edit-title" class="{{ $input }}"
                        placeholder="Opsional">
                </div>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" id="edit-active" value="1" class="accent-ar-red">
                    <span class="text-sm text-ar-text2">Aktif (tampil di homepage)</span>
                </label>
                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="flex-1 py-2.5 bg-ar-red hover:bg-ar-red2 text-white text-xs font-semibold tracking-widest uppercase transition-colors">
                        Simpan
                    </button>
                    <button type="button" onclick="closeEdit()"
                        class="flex-1 py-2.5 border border-ar-border text-ar-text2 hover:text-ar-white text-xs tracking-widest uppercase transition-colors">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // ── Image preview before upload ──
        function previewImages(input) {
            const previewGrid = document.getElementById('preview-grid');
            const titleInputs = document.getElementById('title-inputs');
            const uploadBtn = document.getElementById('upload-btn');
            const files = Array.from(input.files);

            previewGrid.innerHTML = '';
            titleInputs.innerHTML =
                '<p class="text-xs text-ar-text2 uppercase tracking-widest">Caption / Judul (opsional)</p>';

            if (!files.length) {
                previewGrid.classList.add('hidden');
                titleInputs.classList.add('hidden');
                uploadBtn.classList.add('hidden');
                return;
            }

            previewGrid.classList.remove('hidden');
            titleInputs.classList.remove('hidden');
            uploadBtn.classList.remove('hidden');

            files.forEach((file, i) => {
                const reader = new FileReader();
                reader.onload = e => {
                    // Preview
                    const div = document.createElement('div');
                    div.className = 'relative aspect-square bg-ar-gray overflow-hidden';
                    div.innerHTML =
                        `<img src="${e.target.result}" class="w-full h-full object-cover">
                    <span class="absolute bottom-0 left-0 right-0 bg-ar-black/60 text-[9px] text-ar-text2 px-1 py-0.5 truncate">${file.name}</span>`;
                    previewGrid.appendChild(div);

                    // Title input
                    const inputDiv = document.createElement('div');
                    inputDiv.className = 'flex items-center gap-2';
                    inputDiv.innerHTML =
                        `
                    <span class="text-xs text-ar-text2 w-32 truncate shrink-0">${file.name}</span>
                    <input type="text" name="titles[${i}]"
                        placeholder="Caption untuk gambar ini..."
                        class="w-full bg-[#111] border border-ar-border text-ar-white placeholder-ar-text2 px-3 py-2 text-sm focus:border-ar-red focus:outline-none transition-colors">`;
                    titleInputs.appendChild(inputDiv);
                };
                reader.readAsDataURL(file);
            });
        }

        // ── Drag & drop on drop zone ──
        const dropZone = document.getElementById('drop-zone');
        if (dropZone) {
            dropZone.addEventListener('dragover', e => {
                e.preventDefault();
                dropZone.classList.add('border-ar-red');
            });
            dropZone.addEventListener('dragleave', () => {
                dropZone.classList.remove('border-ar-red');
            });
            dropZone.addEventListener('drop', e => {
                e.preventDefault();
                dropZone.classList.remove('border-ar-red');
                const input = document.getElementById('gallery-file-input');
                const dt = new DataTransfer();
                Array.from(e.dataTransfer.files).forEach(f => dt.items.add(f));
                input.files = dt.files;
                previewImages(input);
            });
        }

        // ── Edit modal ──
        function openEdit(id, title, isActive) {
            const modal = document.getElementById('edit-modal');
            const form = document.getElementById('edit-form');
            form.action = `/admin/gallery/${id}`;
            document.getElementById('edit-title').value = title;
            document.getElementById('edit-active').checked = isActive;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeEdit() {
            const modal = document.getElementById('edit-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        document.getElementById('edit-modal')?.addEventListener('click', function(e) {
            if (e.target === this) closeEdit();
        });

        // ── Sortable drag-and-drop reorder ──
        const grid = document.getElementById('sortable-grid');
        if (grid) {
            let draggedEl = null;

            grid.addEventListener('dragstart', e => {
                draggedEl = e.target.closest('.gallery-sort-item');
                setTimeout(() => draggedEl?.classList.add('opacity-40'), 0);
            });
            grid.addEventListener('dragend', () => {
                draggedEl?.classList.remove('opacity-40');
                draggedEl = null;
                saveOrder();
            });
            grid.addEventListener('dragover', e => {
                e.preventDefault();
                const target = e.target.closest('.gallery-sort-item');
                if (target && target !== draggedEl) {
                    const rect = target.getBoundingClientRect();
                    const next = (e.clientX - rect.left) > rect.width / 2;
                    grid.insertBefore(draggedEl, next ? target.nextSibling : target);
                }
            });

            // Make items draggable
            document.querySelectorAll('.gallery-sort-item').forEach(el => {
                el.setAttribute('draggable', 'true');
            });

            function saveOrder() {
                const ids = Array.from(grid.querySelectorAll('.gallery-sort-item')).map(el => el.dataset.id);
                fetch('{{ route('admin.gallery.reorder') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({
                            order: ids
                        }),
                    })
                    .then(r => r.json())
                    .then(() => {
                        // Update badge numbers
                        grid.querySelectorAll('.gallery-sort-item').forEach((el, i) => {
                            const badge = el.querySelector('span[class*="text-[9px]"]');
                            if (badge) {
                                let txt = `#${i + 1}`;
                                if (i === 0) txt += ' — Feature';
                                if (i === 5) txt += ' — Wide';
                                badge.textContent = txt;
                            }
                        });
                    });
            }
        }
    </script>
@endpush
