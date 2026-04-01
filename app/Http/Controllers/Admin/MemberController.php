<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::orderBy('order')->get();
        return view('pages.admin.members.index', compact('members'));
    }

    public function create()
    {
        return view('pages.admin.members.form', ['member' => new Member()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:100',
            'role'      => 'required|string|max:100',
            'bio'       => 'nullable|string',
            'order'     => 'integer|min:0',
            'is_active' => 'boolean',
            'photo'     => 'nullable|image|max:3072',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('members', 'public');
        }

        Member::create($data);

        return redirect()->route('admin.members.index')->with('success', 'Personel berhasil ditambahkan!');
    }

    public function edit(Member $member)
    {
        return view('pages.admin.members.form', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:100',
            'role'      => 'required|string|max:100',
            'bio'       => 'nullable|string',
            'order'     => 'integer|min:0',
            'is_active' => 'boolean',
            'photo'     => 'nullable|image|max:3072',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('photo')) {
            if ($member->photo) Storage::disk('public')->delete($member->photo);
            $data['photo'] = $request->file('photo')->store('members', 'public');
        }

        $member->update($data);

        return redirect()->route('admin.members.index')->with('success', 'Personel berhasil diperbarui!');
    }

    public function destroy(Member $member)
    {
        if ($member->photo) Storage::disk('public')->delete($member->photo);
        $member->delete();
        return back()->with('success', 'Personel dihapus.');
    }
}
