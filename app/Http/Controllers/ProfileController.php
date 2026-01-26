<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;


class ProfileController extends Controller
{

    public function accountForm()
    {
        return view('seller.profile.account');
    }
    /**
     * Update name, email, password
     */
    public function updateAccount(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        // Only update password if user entered one
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Account updated successfully');
    }

    /**
     * Update avatar (Cloudinary)
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = Auth::user();

        // Delete old avatar from Cloudinary if exists
        if ($user->avatar) {
            try {
                Cloudinary::destroy($this->extractPublicId($user->avatar));
            } catch (\Exception $e) {
                // ignore if already deleted
            }
        }

        // Upload new avatar
        $upload = Cloudinary::upload($request->file('avatar')->getRealPath(), [
            'folder' => 'avatars',
            'transformation' => [
                'width' => 400,
                'height' => 400,
                'crop' => 'fill',
                'gravity' => 'face',
            ],
        ]);

        $user->avatar = $upload->getSecurePath();
        $user->save();

        return back()->with('success', 'Profile picture updated successfully!');
    }

    public function deleteProfile()
    {
        $user = Auth::user();

        // Delete avatar from Cloudinary
        if ($user->avatar) {
            try {
                Cloudinary::destroy($this->extractPublicId($user->avatar));
            } catch (\Exception $e) {
                // ignore errors
            }
        }

        // Delete user from DB
        Auth::logout();
        $user->delete();

        return redirect('/')->with('success', 'Profile deleted successfully!');
    }
}
