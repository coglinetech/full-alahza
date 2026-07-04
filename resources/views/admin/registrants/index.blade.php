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

    <div style="margin-bottom:8px;font-size:14px;font-weight:600;">Total Jamaah: {{ $items->total() }}</div>

    <div class="card">
        <div class="card-body">
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Paket</th>
                            <th>HP</th>
                            <th>Dibuat</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $it)
                            <tr>
                                <td>{{ $items->total() - ($items->firstItem() - 1) - $loop->iteration + 1 }}</td>
                                <td>{{ $it->name }}</td>
                                <td class="td-muted">{{ $it->package_option }}</td>
                                <td>{{ $it->phone }}</td>
                                <td class="td-muted">{{ $it->created_at->format('d-m-Y') }}</td>
                                <td class="td-actions">
                                    <a href="{{ route('admin.registrants.edit', $it) }}"
                                        class="btn btn-primary btn-sm">Edit</a>
                                    <button type="button" class="btn btn-secondary btn-sm"
                                        onclick="printPDFRegistrant({{ $it->id }})">Cetak PDF</button>
                                    <form action="{{ route('admin.registrants.destroy', $it) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus data pendaftar ini?');">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top:12px">{{ $items->links('vendor.pagination.admin') }}</div>
        </div>
    </div>

    <style>
        .print-spinner-overlay {
            position: fixed;
            inset: 0;
            background: rgba(255,255,255,0.85);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 99999;
        }
        .print-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #e0e0e0;
            border-top-color: #2563eb;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        .print-spinner-text {
            margin-top: 12px;
            font-size: 14px;
            color: #374151;
            font-weight: 500;
        }
    </style>

    <script>
        let spinnerEl = null;

        function showPrintSpinner() {
            const overlay = document.createElement('div');
            overlay.className = 'print-spinner-overlay';
            overlay.innerHTML = '<div class="print-spinner"></div><div class="print-spinner-text">Menyiapkan dokumen…</div>';
            document.body.appendChild(overlay);
            spinnerEl = overlay;
        }

        function hidePrintSpinner() {
            if (spinnerEl) {
                spinnerEl.remove();
                spinnerEl = null;
            }
        }

        function printPDFRegistrant(registrantId) {
            showPrintSpinner();

            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            document.body.appendChild(iframe);

            const originalTitle = document.title;

            const previewUrl = `/admin/registrants/${registrantId}`;
            fetch(previewUrl)
                .then(response => response.text())
                .then(html => {
                    iframe.contentDocument.write(html);
                    iframe.contentDocument.close();

                    const titleMatch = html.match(/<title>(.+?)<\/title>/);
                    let safeFileName = 'Jamaah_AlAhza_Jamaah';
                    if (titleMatch && titleMatch[1]) {
                        safeFileName = titleMatch[1];
                    }

                    document.title = safeFileName;
                    iframe.contentDocument.title = safeFileName;

                    setTimeout(() => {
                        hidePrintSpinner();
                        iframe.contentWindow.print();
                        iframe.contentWindow.onafterprint = function() {
                            try {
                                document.body.removeChild(iframe);
                                document.title = originalTitle;
                            } catch (e) {}
                        };
                    }, 1500);
                })
                .catch(error => {
                    hidePrintSpinner();
                    console.error('Error loading preview:', error);
                    document.title = originalTitle;
                    try {
                        document.body.removeChild(iframe);
                    } catch (e) {}
                });
        }
    </script>

@endsection
