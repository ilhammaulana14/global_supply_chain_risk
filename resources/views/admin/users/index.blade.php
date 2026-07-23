@extends('layouts.admin')

@section('content')

<div style="display:flex; flex-direction:column; gap:24px;">

    {{-- Header --}}
    <div class="card">
        <div class="card-body" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
            <div style="display:flex; align-items:center; gap:12px;">
                <span style="width:40px; height:40px; border-radius:10px; background:#EBF2FF; color:#2563EB; display:flex; align-items:center; justify-content:center; font-size:20px;">👥</span>
                <div>
                    <h2 class="section-title">User Management</h2>
                    <p class="section-subtitle">Kelola akun pengguna sistem SCRI.</p>
                </div>
            </div>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">+ Tambah User</a>
        </div>
    </div>

    {{-- Search --}}
    <div class="card">
        <div class="card-body">
            <form method="GET" style="display:flex; gap:12px; align-items:center;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 Cari nama atau email..." class="search-input" style="flex:1;">
                <button class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card">
        <div style="overflow-x:auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="text-align:center;">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th style="text-align:center;">Role</th>
                        <th style="text-align:center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    <tr>
                        <td style="text-align:center;">{{ $loop->iteration + ($users->currentPage()-1)*$users->perPage() }}</td>
                        <td style="font-weight:600;">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td style="text-align:center;">
                            @if($user->role == 'admin')
                                <span class="badge badge-red">Admin</span>
                            @else
                                <span class="badge badge-green">User</span>
                            @endif
                        </td>
                        <td style="text-align:center;">
                            <div style="display:flex; align-items:center; justify-content:center; gap:6px;">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-amber" style="padding:6px 14px; font-size:12px;">Edit</a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Hapus user ini?')" class="btn btn-danger" style="padding:6px 14px; font-size:12px;">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:40px; color:#8B95A5;">Tidak ada data.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding:16px 24px; border-top:1px solid #F0F2F5; display:flex; justify-content:flex-end;">
            {{ $users->links() }}
        </div>
    </div>

</div>

@endsection
