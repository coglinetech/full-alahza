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

    <div style="margin-bottom:8px;font-size:14px;font-weight:600;">Total Kuitansi: {{ $items->total() }}</div>

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
<<<<<<< HEAD
                            <th>Aksi</th>
=======
                            <th></th>
>>>>>>> projek_kedua/master
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $item)
                            <tr>
                                <td>{{ $item->display_receipt_number ?? '-' }}</td>
                                <td>{{ $item->payer_name }}</td>
                                <td>{{ $item->amount_text }}</td>
<<<<<<< HEAD
                                <td class="td-muted">{{ $item->receipt_date->format('Y-m-d') }}</td>
                                <td class="td-actions">
                                    <div class="action-dropdown">
                                        <button type="button" class="btn btn-ghost btn-icon" onclick="toggleDropdown(event, this)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                                        </button>
                                        <div class="action-dropdown-menu">
                                            <a href="{{ route('admin.receipts.edit', $item) }}">Edit</a>
                                            <button type="button" onclick="printPDFReceipt({{ $item->id }})">Cetak PDF</button>
                                            <form action="{{ route('admin.receipts.destroy', $item) }}" method="POST" style="margin:0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-danger" onclick="return confirm('Yakin ingin menghapus kuitansi ini?');">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
=======
                                <td class="td-muted">{{ $item->receipt_date->format('d-m-Y') }}</td>
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
>>>>>>> projek_kedua/master
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

<<<<<<< HEAD
            <div style="margin-top:12px">{{ $items->links() }}</div>
        </div>
    </div>

    <style>
        .action-dropdown { display: inline-block; }
        .action-dropdown-menu {
            display: none; position: fixed; flex-direction: column; gap: 2px;
            background: var(--white); min-width: 140px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border: 1px solid var(--line); border-radius: var(--r); z-index: 9999; padding: 4px;
        }
        .action-dropdown-menu button, .action-dropdown-menu a {
            display: block; width: 100%; text-align: left; padding: 6px 10px; font-size: 11.5px;
            color: var(--text-1); border: none; background: none; cursor: pointer; border-radius: 4px; text-decoration: none; font-family: inherit;
        }
        .action-dropdown-menu button:hover, .action-dropdown-menu a:hover { background: var(--line-soft); }
        .action-dropdown-menu .text-danger { color: var(--red); }
        .action-dropdown-menu .text-danger:hover { background: var(--red-pale); }
    </style>

    <script>
        function toggleDropdown(event, btn) {
            event.stopPropagation();
            const dropdown = btn.parentElement;
            const menu = dropdown.querySelector('.action-dropdown-menu');
            const isActive = dropdown.classList.contains('active');
            
            document.querySelectorAll('.action-dropdown.active').forEach(d => {
                d.classList.remove('active');
                const m = d.querySelector('.action-dropdown-menu');
                if (m) m.style.display = 'none';
            });
            
            if (!isActive) {
                dropdown.classList.add('active');
                menu.style.display = 'flex';
                
                const rect = btn.getBoundingClientRect();
                const menuHeight = menu.offsetHeight;
                const spaceBelow = window.innerHeight - rect.bottom;
                
                if (spaceBelow < menuHeight && rect.top > menuHeight) {
                    menu.style.top = (rect.top - menuHeight - 4) + 'px';
                } else {
                    menu.style.top = (rect.bottom + 4) + 'px';
                }
                
                menu.style.left = 'auto';
                menu.style.right = (window.innerWidth - rect.right) + 'px';
            }
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.action-dropdown-menu')) {
                document.querySelectorAll('.action-dropdown.active').forEach(dropdown => {
                    dropdown.classList.remove('active');
                    const m = dropdown.querySelector('.action-dropdown-menu');
                    if (m) m.style.display = 'none';
                });
            }
        });

        window.addEventListener('scroll', function() {
            document.querySelectorAll('.action-dropdown.active').forEach(dropdown => {
                dropdown.classList.remove('active');
                const m = dropdown.querySelector('.action-dropdown-menu');
                if (m) m.style.display = 'none';
            });
        }, true);

=======
            <div style="margin-top:12px">{{ $items->links('vendor.pagination.admin') }}</div>
        </div>
    </div>

    <script>
>>>>>>> projek_kedua/master
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
