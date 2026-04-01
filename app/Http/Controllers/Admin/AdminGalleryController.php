<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminGalleryController extends Controller
{
    public function index()
    {
        $items = GalleryItem::orderBy('order')->get();
        return view('pages.admin.gallery.index', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'images'   => 'required|array|min:1',
            'images.*' => 'image|max:5120',
            'titles'   => 'nullable|array',
            'titles.*' => 'nullable|string|max:100',
        ]);

        // Ambil order tertinggi saat ini
        $maxOrder = GalleryItem::max('order') ?? 0;

        foreach ($request->file('images') as $i => $file) {
            $path  = $file->store('gallery', 'public');
            $title = $request->input("titles.{$i}");

            GalleryItem::create([
                'title'      => $title ?: null,
                'image_path' => $path,
                'order'      => ++$maxOrder,
                'is_active'  => true,
            ]);
        }

        return back()->with('success', count($request->file('images')) . ' gambar berhasil diupload!');
    }

    public function update(Request $request, GalleryItem $galleryItem)
    {
        $request->validate([
            'title' => 'nullable|string|max:100',
        ]);

        $galleryItem->update([
            'title'     => $request->title,
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Gallery item diperbarui!');
    }

    public function destroy(GalleryItem $galleryItem)
    {
        Storage::disk('public')->delete($galleryItem->image_path);
        $galleryItem->delete();

        return back()->with('success', 'Gambar dihapus!');
    }

    /**
     * Update urutan via drag-and-drop (JSON request).
     * Payload: { "order": [3, 1, 5, 2, ...] } (array of IDs)
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'order'   => 'required|array',
            'order.*' => 'integer|exists:gallery_items,id',
        ]);

        foreach ($request->order as $position => $id) {
            GalleryItem::where('id', $id)->update(['order' => $position + 1]);
        }

        return response()->json(['success' => true]);
    }
}
