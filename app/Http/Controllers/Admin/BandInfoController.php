<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BandInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BandInfoController extends Controller
{
    public function edit()
    {
        $bandInfo = BandInfo::getInstance();
        return view('pages.admin.band-info', compact('bandInfo'));
    }

    public function update(Request $request)
    {
        $bandInfo = BandInfo::getInstance();

        $data = $request->validate([
            'band_name'    => 'required|string|max:100',
            'tagline'      => 'nullable|string|max:255',
            'history'      => 'nullable|string',
            'description'  => 'nullable|string',
            'founded_year' => 'nullable|string|max:4',
            'genre'        => 'nullable|string|max:100',
            'origin'       => 'nullable|string|max:100',
            'email'        => 'nullable|email',
            'hero_video'   => 'nullable|url',
            'social_links' => 'nullable|array',
            'hero_image'   => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('hero_image')) {
            if ($bandInfo->hero_image) {
                Storage::disk('public')->delete($bandInfo->hero_image);
            }
            $data['hero_image'] = $request->file('hero_image')->store('band', 'public');
        }

        $bandInfo->update($data);

        return back()->with('success', 'Informasi band berhasil diperbarui!');
    }
}
