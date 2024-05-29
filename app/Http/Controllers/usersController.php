<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class usersController extends Controller
{
    public function show(User $user){
        $user = User::find($user->id);
        return view('admin.clientDetails', compact('user'));
    }

    public function create(){
        return view('admin.addAdmin');
    }

    public function destroy(User $user)
    {
        // Periksa apakah pengguna yang sedang login adalah admin
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('admin.users')->with('error', 'You do not have permission to delete users.');
        }

        // Hapus semua reservasi yang terkait dengan pengguna ini
        // $user->reservations()->delete();

        // Hapus pengguna
        $user->delete();

        // Redirect ke halaman daftar pengguna dengan pesan sukses
        return redirect()->route('users')->with('success', 'User deleted successfully.');
    }
    
}
