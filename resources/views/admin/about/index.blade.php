@extends('layouts.admin')

@section('title', 'Foto About — Al-Ahza Admin')
@section('page-title', 'Foto About')
@section('breadcrumb')
    <span class="topbar-breadcrumb-sep">›</span>
    <span class="topbar-breadcrumb-current">Foto About</span>
@endsection

@section('content')
<div style="max-width:720px;">
    <div class="page-header">
        <div class="page-header-left">
            <h1>Foto Halaman About</h1>
            <p>Kelola foto yang ditampilkan di section "Tentang Kami" pada halaman utama website.</p>
        </div>
    </div>

    <!-- Preview current -->
    <div class="card" style="margin-bottom:24px;">
        <div class="card-header">
            <div class="card-header-title">Foto Saat Ini</div>
            @if(isset($aboutImage) && $aboutImage->image_path)
            <span class="badge badge-green">Terpasang</span>
            @else
            <span class="badge badge-gray">Belum ada foto</span>
            @endif
        </div>
        <div class="card-body">
            @if(isset($aboutImage) && $aboutImage->image_path)
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;align-items:start;">
                <div>
                    <div class="form-hint" style="margin-bottom:10px;">Tampilan di website (rasio 4:5):</div>
                    <div style="border-radius:14px;overflow:hidden;border:1px solid rgba(92,61,46,0.1);background:var(--off-white);aspect-ratio:4/5;max-width:240px;">
                            <img src="{{ media_url($aboutImage->image_path) }}" alt="About"
                             style="width:100%;height:100%;object-fit:cover;display:block;">
                    </div>
                </div>
                <div>
                    <div style="margin-bottom:16px;">
                        <div class="form-hint" style="margin-bottom:4px;">Path file:</div>
                        <code style="font-size:12px;background:var(--off-white);padding:6px 10px;border-radius:6px;display:block;word-break:break-all;color:var(--text-secondary);">{{ $aboutImage->image_path }}</code>
                    </div>
                    @if(isset($aboutImage->updated_at))
<div class="form-hint">Diperbarui: {{ $aboutImage->updated_at }}</div>
@endif
                </div>
            </div>
            @else
            <div style="text-align:center;padding:32px;color:var(--text-secondary);">
                <div style="width:56px;height:56px;background:var(--off-white);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;color:rgba(92,61,46,0.2);">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                </div>
                <p style="font-size:13px;">Belum ada foto. Upload foto untuk mengganti ilustrasi default.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Upload form -->
    <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        @if($errors->any())
        <div class="alert alert-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <div><ul style="margin:0 0 0 16px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        </div>
        @endif

        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><div class="card-header-title">Ganti Foto About</div></div>
            <div class="card-body">
                @if(isset($aboutImage) && $aboutImage->image_path)
                <div style="margin-bottom:14px;">
                    <label style="display:flex;align-items:center;gap:10px;font-weight:500;cursor:pointer;">
                        <input type="checkbox" name="remove_image" value="1" style="width:16px;height:16px;">
                        Hapus foto saat ini dari storage dan database
                    </label>
                </div>
                @endif

                <div class="upload-zone" style="margin-bottom:16px;">
                    <input type="file" name="image" accept="image/*" onchange="previewAbout(this)">
                    <div class="upload-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                    </div>
                    <div class="upload-title">Klik atau drag foto di sini</div>
                    <div class="upload-sub">PNG, JPG, WebP • Maks 2MB • Rasio ideal 4:5 (portrait) • Foto otomatis dikompres</div>
                </div>

                <div id="aboutPreview" style="display:none;margin-bottom:16px;">
                    <div class="form-hint" style="margin-bottom:8px;">Preview foto baru:</div>
                    <div style="display:flex;align-items:flex-start;gap:16px;">
                        <div style="border-radius:10px;overflow:hidden;border:1px solid rgba(92,61,46,0.1);background:var(--off-white);width:120px;aspect-ratio:4/5;flex-shrink:0;">
                            <img id="aboutPreviewImg" src="" style="width:100%;height:100%;object-fit:cover;display:block;">
                        </div>
                        <div style="padding-top:4px;">
                            <div class="form-hint" style="margin-bottom:8px;">Tampak natural di section About dengan rasio 4:5.</div>
                            <button type="button" onclick="clearAboutPreview()" class="btn btn-danger btn-sm">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                Batalkan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Info stats tambahan -->
                <div style="background:rgba(197,160,78,0.06);border:1px solid rgba(197,160,78,0.15);border-radius:10px;padding:16px;margin-top:8px;">
                    <div style="font-size:12px;font-weight:600;color:var(--brown);margin-bottom:10px;">Data Statistik About (tampil sebagai overlay)</div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                        <div class="form-group">
                            <label>Jumlah Jamaah</label>
                            <input type="number" name="jamaah_count" value="{{ old('jamaah_count', $aboutStats['jamaah_count'] ?? 2500) }}" min="0">
                        </div>
                        <div class="form-group">
                            <label>Tahun Berdiri</label>
                            <input type="number" name="tahun_berdiri" value="{{ old('tahun_berdiri', $aboutStats['tahun_berdiri'] ?? 2010) }}" min="1900" max="2099">
                        </div>
                        <div class="form-group">
                            <label>Destinasi</label>
                            <input type="number" name="destinasi_count" value="{{ old('destinasi_count', $aboutStats['destinasi_count'] ?? 12) }}" min="0">
                        </div>
                        <div class="form-group">
                            <label>Rating Kepuasan (%)</label>
                            <input type="number" name="rating_pct" value="{{ old('rating_pct', $aboutStats['rating_pct'] ?? 98) }}" min="0" max="100">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div style="display:flex;gap:12px;justify-content:flex-end;">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                Simpan Foto & Data
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function previewAbout(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('aboutPreviewImg').src = e.target.result;
            document.getElementById('aboutPreview').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function clearAboutPreview() {
    document.querySelector('input[name="image"]').value = '';
    document.getElementById('aboutPreview').style.display = 'none';
}
</script>
@endpush