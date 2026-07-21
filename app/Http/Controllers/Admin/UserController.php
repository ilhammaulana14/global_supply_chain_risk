<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * List User
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");

            });

        }

        $users = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Form Tambah User
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Simpan User
     */
    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required|max:255',

            'email' => 'required|email|unique:users,email',

            'password' => 'required|min:6|confirmed',

            'role' => 'required|in:admin,user',

        ]);

        User::create([

            'name' => $request->name,

            'email' => $request->email,

            'password' => Hash::make($request->password),

            'role' => $request->role,

        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Form Edit
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update User
     */
    public function update(Request $request, User $user)
    {
        $request->validate([

            'name' => 'required|max:255',

            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],

            'role' => 'required|in:admin,user',

        ]);

        $user->name = $request->name;

        $user->email = $request->email;

        $user->role = $request->role;

        if ($request->filled('password')) {

            $user->password = Hash::make($request->password);

        }

        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil diupdate.');
    }

    /**
     * Hapus User
     */
    public function destroy(User $user)
    {
        if ($user->id == auth()->id()) {

            return back()->with(
                'error',
                'Tidak dapat menghapus akun sendiri.'
            );

        }

        $user->delete();

        return back()->with(
            'success',
            'User berhasil dihapus.'
        );
    }
}
