@extends('layouts.admin')

@section('content')

<div style="max-width:640px;">
    <div class="card">
        <div class="card-body">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px;">
                <span style="width:40px; height:40px; border-radius:10px; background:#EBF2FF; color:#2563EB; display:flex; align-items:center; justify-content:center; font-size:20px;">➕</span>
                <div>
                    <h2 class="section-title">Tambah User</h2>
                    <p class="section-subtitle">Buat akun pengguna baru</p>
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

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div style="display:flex; flex-direction:column; gap:16px;">
                    <div>
                        <label style="display:block; font-size:12px; font-weight:700; color:#8B95A5; text-transform:uppercase; letter-spacing:.5px; margin-bottom:6px;">Nama</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="search-input">
                    </div>
                    <div>
                        <label style="display:block; font-size:12px; font-weight:700; color:#8B95A5; text-transform:uppercase; letter-spacing:.5px; margin-bottom:6px;">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="search-input">
                    </div>
                    <div>
                        <label style="display:block; font-size:12px; font-weight:700; color:#8B95A5; text-transform:uppercase; letter-spacing:.5px; margin-bottom:6px;">Password</label>
                        <input type="password" name="password" class="search-input">
                    </div>
                    <div>
                        <label style="display:block; font-size:12px; font-weight:700; color:#8B95A5; text-transform:uppercase; letter-spacing:.5px; margin-bottom:6px;">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="search-input">
                    </div>
                    <div>
                        <label style="display:block; font-size:12px; font-weight:700; color:#8B95A5; text-transform:uppercase; letter-spacing:.5px; margin-bottom:6px;">Role</label>
                        <select name="role" class="search-input">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
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
