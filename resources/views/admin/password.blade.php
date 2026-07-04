@extends('layouts.admin')

@section('title', 'Ganti Password — Al-Ahza Admin')
@section('page-title', 'Ganti Password')
@section('breadcrumb')
    <span class="tb-crumb-sep">›</span>
    <span class="tb-crumb-cur">Ganti Password</span>
@endsection

@push('styles')
<style>
    .pw-wrap {
        position: relative;
    }
    .pw-wrap input {
        padding-right: 36px;
    }
    .pw-toggle {
        position: absolute;
        right: 6px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        padding: 6px;
        color: var(--text-3);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.15s;
    }
    .pw-toggle:hover {
        color: var(--text-1);
    }
    .pw-toggle svg {
        width: 16px;
        height: 16px;
        stroke: currentColor;
        fill: none;
        stroke-width: 1.75;
    }
    .pw-toggle .eye-off {
        display: none;
    }
    .pw-toggle.showing .eye-on {
        display: none;
    }
    .pw-toggle.showing .eye-off {
        display: block;
    }
</style>
@endpush

@section('content')
<div style="max-width:480px;">
    <div class="page-header">
        <h1>Ganti Password</h1>
        <p>Perbarui password akun admin Anda.</p>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.password.update') }}">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="form-group">
                        <label for="new_password">Password Baru <span class="req">*</span></label>
                        <div class="pw-wrap">
                            <input type="password" id="new_password" name="new_password" required autocomplete="new-password" minlength="8">
                            <button type="button" class="pw-toggle" tabindex="-1" onclick="togglePw(this)">
                                <svg class="eye-on" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg class="eye-off" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19M14.12 14.12a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                            </button>
                        </div>
                        <div class="form-hint">Minimal 8 karakter.</div>
                        @error('new_password')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="new_password_confirmation">Konfirmasi Password Baru <span class="req">*</span></label>
                        <div class="pw-wrap">
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" required autocomplete="new-password">
                            <button type="button" class="pw-toggle" tabindex="-1" onclick="togglePw(this)">
                                <svg class="eye-on" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg class="eye-off" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19M14.12 14.12a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div style="margin-top:20px;display:flex;gap:8px;">
                    <button type="submit" class="btn btn-primary">Simpan Password</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePw(btn) {
        const wrap = btn.closest('.pw-wrap');
        const input = wrap.querySelector('input');
        const isPw = input.type === 'password';
        input.type = isPw ? 'text' : 'password';
        btn.classList.toggle('showing', !isPw);
    }
</script>
@endpush
