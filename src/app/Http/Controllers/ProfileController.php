<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Profiles\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function create() {
        return view('profiles/create');
    }

    public function store(ProfileRequest $request)
    {
        $validated = $request->validated();

        // 画像は任意なので if を使う
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        $validated['user_id'] = auth()->id();

        Profile::create($validated);

        return redirect('/');
    }

    public function edit()
    {
        $profile = Auth::user()->profile;

        return view('profiles.edit', compact('profile'));
    }

    public function update(ProfileRequest $request)
    {
        $validated = $request->validated();

        $user = auth()->user();
        $profile = $user->profile;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        $profile->update($validated);

        return redirect('/mypage');
}
}
