@extends('layouts.admin')

@section('title', 'Cetak Kuitansi - Admin')
@section('page-title', 'Cetak Kuitansi')

@section('content')

    <div class="page-header">
        <div>
            <h1>Cetak Kuitansi</h1>
            <p>Kelola dan cetak kuitansi pembayaran.</p>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('admin.receipts.create') }}" class="btn btn-primary">Tambah Kuitansi</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>Tanda Terima Dari</th>
                            <th>Uang Sejumlah</th>
                            <th>Tanggal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $item)
                            <tr>
                                <td>{{ $item->display_receipt_number ?? '-' }}</td>
                                <td>{{ $item->payer_name }}</td>
                                <td>{{ $item->amount_text }}</td>
                                <td class="td-muted">{{ $item->receipt_date->format('Y-m-d') }}</td>
                                <td class="td-actions">
                                    <a href="{{ route('admin.receipts.edit', $item) }}"
                                        class="btn btn-primary btn-sm">Edit</a>
                                    <button type="button" class="btn btn-secondary btn-sm"
                                        onclick="printPDFReceipt({{ $item->id }})">Cetak PDF</button>
                                    <form action="{{ route('admin.receipts.destroy', $item) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus kuitansi ini?');">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="td-muted">Belum ada kuitansi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="margin-top:12px">{{ $items->links() }}</div>
        </div>
    </div>

    <script>
        function printPDFReceipt(receiptId) {
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            document.body.appendChild(iframe);

            const originalTitle = document.title;
            const previewUrl = `/admin/receipts/${receiptId}`;

            fetch(previewUrl)
                .then(response => response.text())
                .then(html => {
                    iframe.contentDocument.write(html);
                    iframe.contentDocument.close();
                    document.title = 'Kuitansi_' + receiptId;
                    iframe.contentDocument.title = 'Kuitansi_' + receiptId;

                    setTimeout(() => {
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
                    console.error('Error loading preview:', error);
                    try {
                        document.body.removeChild(iframe);
                    } catch (e) {}
                });
        }
    </script>

@endsection
