<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {

        $this->settings = Settings::find(1);
    }

    public function update(Request $request)
    {
        request()->validate([
            'username' => 'max:160|required',
            'name' => 'max:160|required',
            'email' => 'email|max:160|required',
        ]);

        $user = Auth::user();
        $data = $request->all();
        $user->update(['name' => $data['name']]);
        $user->update(['username' => $data['username']]);
        $user->update(['email' => $data['email']]);

        if ($data['password'] !== null) {
            $user->update(['password' => Hash::make($data['password'])]);
        }

        return redirect('/admin/user')->with('success', 'Your user information was successfully updated.');
    }

    public function showForm()
    {
        return view('user', [
            'user' => Auth::user(),
            'settings' => $this->settings,
            'classes' => 'page',
        ]);
    }
    //
}
