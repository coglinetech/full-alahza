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
                        @foreach ($items as $it)
                            <tr>
                                <td>{{ $it->name }}</td>
                                <td class="td-muted">{{ $it->package_option }}</td>
                                <td>{{ $it->phone }}</td>
                                <td class="td-muted">{{ $it->created_at->format('Y-m-d') }}</td>
                                <td class="td-actions">
                                    <a href="{{ route('admin.registrants.edit', $it) }}"
                                        class="btn btn-primary btn-sm">Edit</a>
                                    <button type="button" class="btn btn-secondary btn-sm"
                                        onclick="printPDFRegistrant({{ $it->id }})">Cetak PDF</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top:12px">{{ $items->links() }}</div>
        </div>
    </div>

    <script>
        function printPDFRegistrant(registrantId) {
            // Create iframe untuk print
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            document.body.appendChild(iframe);

            // Save original title
            const originalTitle = document.title;

            // Fetch preview untuk registrant ini
            const previewUrl = `/admin/registrants/${registrantId}`;
            fetch(previewUrl)
                .then(response => response.text())
                .then(html => {
                    // Write HTML ke iframe
                    iframe.contentDocument.write(html);
                    iframe.contentDocument.close();

                    // Extract filename dari title tag di preview
                    const titleMatch = html.match(/<title>(.+?)<\/title>/);
                    let safeFileName = 'Jamaah_AlAhza_Jamaah';
                    if (titleMatch && titleMatch[1]) {
                        safeFileName = titleMatch[1];
                    }

                    // Set document title untuk PDF filename
                    document.title = safeFileName;
                    iframe.contentDocument.title = safeFileName;

                    // Wait untuk CSS fully rendered sebelum print
                    setTimeout(() => {
                        iframe.contentWindow.print();
                        // Remove iframe dan restore title setelah print dialog ditutup
                        iframe.contentWindow.onafterprint = function() {
                            try {
                                document.body.removeChild(iframe);
                                document.title = originalTitle;
                            } catch (e) {}
                        };
                    }, 1500);
                })
                .catch(error => {
                    console.error('Error loading preview:', error);
                    document.title = originalTitle;
                    try {
                        document.body.removeChild(iframe);
                    } catch (e) {}
                });
        }
    </script>

@endsection
