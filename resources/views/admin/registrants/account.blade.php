@extends('layouts.admin')

@section('title', 'Kelola Akun Mobile - Admin')
@section('page-title', 'Kelola Akun Mobile')

@section('content')

    <div class="page-header">
        <div>
            <h1>Kelola Akun Mobile: {{ $registrant->name }}</h1>
            <p>Buat atau kelola password login aplikasi mobile untuk jamaah ini.</p>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('admin.registrants.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" style="margin-bottom:20px;">
            <ul style="margin:0; padding-left:20px;">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success" style="margin-bottom:20px; padding:15px; background-color:#d4edda; color:#155724; border-radius:4px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">

        <div>
            <div class="card">
                <div class="card-body">
                    <h3 style="margin-top:0;">Info Akun</h3>
                    
                    @if ($registrant->user_id)
                        <!-- Jika sudah ada akun -->
                        <div style="margin-bottom:20px;">
                            <p style="margin:0 0 5px; color:var(--text-1);">Status: <span style="color:green; font-weight:bold;">Telah Terdaftar</span></p>
                            <p style="margin:0 0 5px; color:var(--text-1);">Email Login: <strong>{{ $registrant->email }}</strong></p>
                            <small style="color:var(--text-2);">Jika ingin mengubah email login, Anda harus mengubahnya melalui halaman <a href="{{ route('admin.registrants.edit', $registrant) }}">Edit Data Jamaah</a>.</small>
                        </div>

                        <hr style="border:0; border-top:1px solid var(--line); margin:20px 0;">

                        <h4 style="margin-top:0;">Ganti Password</h4>
                        <form method="POST" action="{{ route('admin.registrants.update_account', $registrant) }}">
                            @csrf
                            @method('PUT')
                            <div style="margin-bottom:15px;">
                                <label style="display:block; margin-bottom:5px; font-weight:500;">Password Baru</label>
                                <input type="password" name="password" class="form-input" required minlength="6" style="width:100%; padding:10px; border:1px solid var(--line); border-radius:4px;">
                                <small style="color:var(--text-2); display:block; margin-top:5px;">Minimal 6 karakter.</small>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary">Simpan Password Baru</button>
                            </div>
                        </form>

                        <hr style="border:0; border-top:1px solid var(--line); margin:20px 0;">

                        <h4 style="margin-top:0; color:var(--red);">Hapus Akses Login</h4>
                        <p style="color:var(--text-2); margin-bottom:15px; font-size:14px;">Menghapus akun tidak akan menghapus data pendaftar umrah, ini hanya akan mencabut akses login aplikasi mobile dari jamaah ini.</p>
                        <form method="POST" action="{{ route('admin.registrants.destroy_account', $registrant) }}" onsubmit="return confirm('Yakin ingin menghapus akses login untuk jamaah ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="background-color:var(--red); color:white; border:none; padding:8px 16px; border-radius:4px; cursor:pointer;">Hapus Akun Mobile</button>
                        </form>

                    @else
                        <!-- Jika belum ada akun -->
                        <div style="margin-bottom:20px;">
                            <p style="margin:0 0 5px; color:var(--text-1);">Status: <span style="color:var(--red); font-weight:bold;">Belum Memiliki Akun</span></p>
                        </div>

                        @if ($registrant->email)
                            <form method="POST" action="{{ route('admin.registrants.store_account', $registrant) }}">
                                @csrf
                                <div style="margin-bottom:15px;">
                                    <label style="display:block; margin-bottom:5px; font-weight:500;">Email Login</label>
                                    <input type="email" value="{{ $registrant->email }}" disabled style="width:100%; padding:10px; border:1px solid var(--line); border-radius:4px; background-color:var(--line-soft); color:var(--text-2); cursor:not-allowed;">
                                    <small style="color:var(--text-2); display:block; margin-top:5px;">Diambil dari data email jamaah. Jika ingin diubah, lakukan di <a href="{{ route('admin.registrants.edit', $registrant) }}">Edit Data Jamaah</a>.</small>
                                </div>
                                <div style="margin-bottom:20px;">
                                    <label style="display:block; margin-bottom:5px; font-weight:500;">Password Login</label>
                                    <input type="password" name="password" required minlength="6" style="width:100%; padding:10px; border:1px solid var(--line); border-radius:4px;">
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary">Buat Akun Sekarang</button>
                                </div>
                            </form>
                        @else
                            <div style="padding:15px; background-color:#fff3cd; color:#856404; border:1px solid #ffeeba; border-radius:4px;">
                                Jamaah ini tidak memiliki Email. Silakan isi alamat Email jamaah melalui halaman <a href="{{ route('admin.registrants.edit', $registrant) }}" style="font-weight:bold; color:#856404; text-decoration:underline;">Edit Data Jamaah</a> terlebih dahulu.
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>

    </div>

@endsection
