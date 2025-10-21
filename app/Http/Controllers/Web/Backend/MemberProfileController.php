<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class MemberProfileController extends Controller
{
    /**
     * Display the member profile page.
     */
    public function index(): View
    {
        $user = Auth::user();
        return view('backend.layouts.member.profile', compact('user'));
    }

    /**
     * Update the member's profile information.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('member.profile')->with('success', 'Profile berhasil diperbarui!');
    }

    /**
     * Update the member's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('member.profile')->with('success', 'Password berhasil diperbarui!');
    }

    /**
     * Update the member's profile picture.
     */
    public function updateProfilePicture(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $user = Auth::user();
        
        // Delete old avatar if exists
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Store new avatar
        $avatarPath = $request->file('avatar')->store('profile', 'public');
        
        $user->update([
            'avatar' => $avatarPath,
        ]);

        return redirect()->route('member.profile')->with('success', 'Foto profil berhasil diperbarui!');
    }
}
