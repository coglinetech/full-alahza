@extends('layouts.admin')

@section('title', (isset($testimonial) ? 'Edit' : 'Tambah') . ' Testimoni — Al-Ahza Admin')
@section('page-title', isset($testimonial) ? 'Edit Testimoni' : 'Tambah Testimoni')
@section('breadcrumb')
    <span class="topbar-breadcrumb-sep">›</span>
    <a href="{{ route('admin.testimonials.index') }}">Testimoni</a>
    <span class="topbar-breadcrumb-sep">›</span>
    <span class="topbar-breadcrumb-current">{{ isset($testimonial) ? 'Edit' : 'Tambah' }}</span>
@endsection

@section('content')
<div style="max-width:680px;">
    <div class="page-header">
        <div class="page-header-left">
            <h1>{{ isset($testimonial) ? 'Edit Testimoni' : 'Tambah Testimoni' }}</h1>
            <p>{{ isset($testimonial) ? 'Perbarui data testimoni jamaah.' : 'Tambahkan ulasan dan testimoni dari jamaah.' }}</p>
        </div>
        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            Kembali
        </a>
    </div>

    <form action="{{ isset($testimonial) ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}"
          method="POST">
        @csrf
        @if(isset($testimonial)) @method('PUT') @endif

        @if($errors->any())
        <div class="alert alert-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <div><ul style="margin:0 0 0 16px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        </div>
        @endif

        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><div class="card-header-title">Data Jamaah</div></div>
            <div class="card-body">
                <div class="form-grid form-grid-2">
                    <div class="form-group">
                        <label>Nama Jamaah <span class="req">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $testimonial->name ?? '') }}"
                               placeholder="contoh: Bapak Hendra" required>
                    </div>
                    <div class="form-group">
                        <label>Kota Asal</label>
                        <input type="text" name="city" value="{{ old('city', $testimonial->city ?? '') }}"
                               placeholder="contoh: Jakarta">
                    </div>
                    <div class="form-group">
                        <label>Nama Paket yang Diikuti</label>
                        <input type="text" name="package_name" value="{{ old('package_name', $testimonial->package_name ?? '') }}"
                               placeholder="contoh: Umroh Reguler 9 Hari">
                    </div>
                    <div class="form-group">
                        <label>Tahun Keberangkatan</label>
                        <input type="text" name="year" value="{{ old('year', $testimonial->year ?? '') }}"
                               placeholder="contoh: 2024">
                    </div>
                </div>
            </div>
        </div>

        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><div class="card-header-title">Ulasan</div></div>
            <div class="card-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Rating <span class="req">*</span></label>
                        <div class="stars-input" id="starsInput">
                            @for($s = 1; $s <= 5; $s++)
                            <button type="button" data-val="{{ $s }}"
                                    class="{{ $s <= old('rating', $testimonial->rating ?? 5) ? 'active' : '' }}"
                                    onclick="setRating({{ $s }})">★</button>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="ratingVal" value="{{ old('rating', $testimonial->rating ?? 5) }}">
                    </div>
                    <div class="form-group">
                        <label>Isi Testimoni <span class="req">*</span></label>
                        <textarea name="content" rows="5" placeholder="Ceritakan pengalaman ibadah bersama Al-Ahza..." required>{{ old('content', $testimonial->content ?? '') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                            <label class="toggle">
                                <input type="checkbox" name="is_active" value="1"
                                       {{ old('is_active', $testimonial->is_active ?? true) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                            Tampilkan di website
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div style="display:flex;gap:12px;justify-content:flex-end;">
            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                {{ isset($testimonial) ? 'Simpan Perubahan' : 'Tambah Testimoni' }}
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function setRating(val) {
    document.getElementById('ratingVal').value = val;
    document.querySelectorAll('#starsInput button').forEach((btn, i) => {
        btn.classList.toggle('active', i < val);
    });
}
</script>
@endpush