@extends('layouts.admin')

@section('title', 'Pendaftaran Jamaah - Admin')
@section('page-title', 'Pendaftaran Jamaah')

@section('content')

<div class="page-header">
    <div>
        <h1>Pendaftaran Jamaah</h1>
        <p>Kelola data pendaftar umrah.</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.registrants.create') }}" class="btn btn-primary">Tambah Jamaah</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Paket</th>
                        <th>HP</th>
                        <th>Dibuat</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $it)
                    <tr>
                        <td>{{ $it->name }}</td>
                        <td class="td-muted">{{ $it->package_option }}</td>
                        <td>{{ $it->phone }}</td>
                        <td class="td-muted">{{ $it->created_at->format('Y-m-d') }}</td>
                        <td class="td-actions">
                            <a href="{{ route('admin.registrants.show', $it) }}" class="btn btn-ghost btn-sm">Preview</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top:12px">{{ $items->links() }}</div>
    </div>
</div>

@endsection
