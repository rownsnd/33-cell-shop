<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class ProfileAdminController extends Controller
{
    public function index(){
        return view('admin.profile');
    }

    public function update(Request $request, $id){

        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email,' . $user->id . ',id|max:255',
            'contact' => 'required|string',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'contact.required' => 'Nomor telepon wajib diisi.',
        ]);

        $user->update($validatedData);

        return redirect()->route('profile.index')->with('success', 'Data berhasil diperbarui.');
    }
}
