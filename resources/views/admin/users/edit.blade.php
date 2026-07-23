@extends('layouts.admin')

@section('content')

<div style="max-width:640px;">
    <div class="card">
        <div class="card-body">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px;">
                <span style="width:40px; height:40px; border-radius:10px; background:#FEF3D9; color:#E5A030; display:flex; align-items:center; justify-content:center; font-size:20px;">✏</span>
                <div>
                    <h2 class="section-title">Edit User</h2>
                    <p class="section-subtitle">Ubah data pengguna: {{ $user->name }}</p>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-error" style="margin-bottom:20px; flex-direction:column; align-items:flex-start;">
                    <strong>Terdapat kesalahan:</strong>
                    <ul style="list-style:disc; margin-left:20px; margin-top:6px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                <div style="display:flex; flex-direction:column; gap:16px;">
                    <div>
                        <label style="display:block; font-size:12px; font-weight:700; color:#8B95A5; text-transform:uppercase; letter-spacing:.5px; margin-bottom:6px;">Nama</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="search-input">
                    </div>
                    <div>
                        <label style="display:block; font-size:12px; font-weight:700; color:#8B95A5; text-transform:uppercase; letter-spacing:.5px; margin-bottom:6px;">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="search-input">
                    </div>
                    <div>
                        <label style="display:block; font-size:12px; font-weight:700; color:#8B95A5; text-transform:uppercase; letter-spacing:.5px; margin-bottom:6px;">Password Baru</label>
                        <input type="password" name="password" class="search-input">
                        <p style="font-size:11px; color:#8B95A5; margin-top:4px;">Kosongkan jika tidak ingin mengubah password.</p>
                    </div>
                    <div>
                        <label style="display:block; font-size:12px; font-weight:700; color:#8B95A5; text-transform:uppercase; letter-spacing:.5px; margin-bottom:6px;">Role</label>
                        <select name="role" class="search-input">
                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                    <div style="display:flex; gap:10px; margin-top:8px;">
                        <button class="btn btn-primary">Simpan</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
