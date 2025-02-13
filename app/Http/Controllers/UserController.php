<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'username' => 'max:160|required',
            'name' => 'max:160|required',
            'email' => 'email|max:160|required',
        ]);

        // Get the current user and update it.
        $user = Auth::user();
        $user->update([
            'name' => request('name'),
            'username' => request('username'),
            'email' => request('email'),
        ]);

        // Update password.
        if (request('password') !== null) {
            $user->update(['password' => Hash::make(request('password'))]);
        }

        return redirect('/admin/user')->with('success', 'Your user information was successfully updated.');
    }

    public function showForm()
    {
        return view('user', [
            'user' => Auth::user(),
            'settings' => Settings::find(1),
            'classes' => 'page',
        ]);
    }
}
