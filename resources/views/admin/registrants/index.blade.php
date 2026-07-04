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
                            <th>Aksi</th>
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
                                    <div class="action-dropdown">
                                        <button type="button" class="btn btn-ghost btn-icon" onclick="toggleDropdown(event, this)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                                        </button>
                                        <div class="action-dropdown-menu">
                                            <a href="{{ route('admin.registrants.account', $it) }}">{{ $it->user_id ? 'Kelola Akun Mobile' : 'Buat Akun Mobile' }}</a>
                                            <a href="{{ route('admin.registrants.edit', $it) }}">Edit</a>
                                            <button type="button" onclick="printPDFRegistrant({{ $it->id }})">Cetak PDF</button>
                                            <form action="{{ route('admin.registrants.destroy', $it) }}" method="POST" style="margin:0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-danger" onclick="return confirm('Yakin ingin menghapus data pendaftar ini?');">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

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
