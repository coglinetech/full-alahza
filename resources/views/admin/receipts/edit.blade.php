@extends('layouts.admin')

@section('title', 'Edit Kuitansi - Admin')
@section('page-title', 'Edit Kuitansi')

@section('content')

    <div class="page-header">
        <div>
            <h1>Edit Kuitansi</h1>
            <p>Perbarui data kuitansi dan lihat preview sebelum mencetak.</p>
        </div>
        <div class="page-header-actions">
            <button type="button" class="btn btn-primary" onclick="printPDF()" id="printPdfBtn">Cetak PDF</button>
            <a href="{{ route('admin.receipts.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">

        <div>
            <form id="receiptForm" method="POST" action="{{ route('admin.receipts.update', $receipt) }}">
                @csrf
                @method('PUT')
                <div class="form-grid" style="display:grid;grid-template-columns:1fr;gap:12px;">
                    <label class="form-group">
                        <span>Nomor Kuitansi</span>
                        <input type="text" id="receipt_number" name="receipt_number"
                            value="{{ old('receipt_number', $displayNumber ?? $receipt->receipt_number) }}" readonly>
                    </label>
                    <label class="form-group">
                        <span>Tanda Terima Dari</span>
                        <input type="text" name="payer_name" value="{{ old('payer_name', $receipt->payer_name) }}"
                            required oninput="updatePreview()">
                    </label>
                    <label class="form-group">
                        <span>Uang Sejumlah</span>
                        <input type="text" id="amount_text" name="amount_text"
                            value="{{ old('amount_text', $receipt->amount_text) }}" required
                            oninput="handleAmountInput(event)">
                    </label>
                    <label class="form-group">
                        <span>Uang Terbilang</span>
                        <input type="text" id="amount_in_words" readonly>
                    </label>
                    <label class="form-group">
                        <span>Untuk Pembayaran</span>
                        <input type="text" name="description" value="{{ old('description', $receipt->description) }}"
                            required oninput="updatePreview()">
                    </label>
                    <label class="form-group">
                        <span>Harga Paket</span>
                        <input type="text" id="package_price" name="package_price"
                            value="{{ old('package_price', $receipt->package_price) }}" oninput="handlePackageInput(event)">
                    </label>
                    <label class="form-group">
                        <span>Tanggal Kuitansi</span>
                        <input type="date" name="receipt_date"
                            value="{{ old('receipt_date', $receipt->receipt_date?->format('Y-m-d')) }}" required
                            onchange="updatePreview()">
                    </label>
                    <div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>

        <div>
            <div class="card">
                <div class="card-body" id="previewArea" style="min-height:420px;">
                    @include('admin.receipts.preview', ['data' => $receipt])
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            function getVal(name) {
                const el = document.querySelector('[name="' + name + '"]');
                return el ? el.value : '';
            }

            function formatRupiah(value) {
                const number = Number(String(value).replace(/[^0-9]/g, '')) || 0;
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    maximumFractionDigits: 0,
                }).format(number);
            }

            function parseRupiah(value) {
                return Number(String(value).replace(/[^0-9]/g, '')) || 0;
            }

            function numberToWords(number) {
                const words = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh',
                    'sebelas'
                ];
                if (number < 12) return words[number];
                if (number < 20) return numberToWords(number - 10) + ' belas';
                if (number < 100) return numberToWords(Math.floor(number / 10)) + ' puluh' + (number % 10 ? ' ' + numberToWords(
                    number % 10) : '');
                if (number < 200) return 'seratus' + (number - 100 ? ' ' + numberToWords(number - 100) : '');
                if (number < 1000) return numberToWords(Math.floor(number / 100)) + ' ratus' + (number % 100 ? ' ' +
                    numberToWords(number % 100) : '');
                if (number < 2000) return 'seribu' + (number - 1000 ? ' ' + numberToWords(number - 1000) : '');
                if (number < 1000000) return numberToWords(Math.floor(number / 1000)) + ' ribu' + (number % 1000 ? ' ' +
                    numberToWords(number % 1000) : '');
                if (number < 1000000000) return numberToWords(Math.floor(number / 1000000)) + ' juta' + (number % 1000000 ?
                    ' ' + numberToWords(number % 1000000) : '');
                if (number < 1000000000000) return numberToWords(Math.floor(number / 1000000000)) + ' miliar' + (number %
                    1000000000 ? ' ' + numberToWords(number % 1000000000) : '');
                return numberToWords(Math.floor(number / 1000000000000)) + ' triliun' + (number % 1000000000000 ? ' ' +
                    numberToWords(number % 1000000000000) : '');
            }

            function updateTerbilang(value) {
                const amount = parseRupiah(value);
                const words = amount ? numberToWords(amount) + ' rupiah' : '-';
                document.getElementById('amount_in_words').value = words.replace(/\s+/g, ' ').trim().replace(/^./, str => str
                    .toUpperCase());
            }

            function handleAmountInput(event) {
                const input = event.target;
                const raw = parseRupiah(input.value);
                input.value = formatRupiah(raw);
                updateTerbilang(input.value);
                updatePreview();
            }

            function handlePackageInput(event) {
                const input = event.target;
                const raw = parseRupiah(input.value);
                input.value = formatRupiah(raw);
                updatePreview();
            }

            function updatePreview() {
                const data = {
                    receipt_number: getVal('receipt_number'),
                    payer_name: getVal('payer_name'),
                    amount_text: getVal('amount_text'),
                    description: getVal('description'),
                    package_price: getVal('package_price'),
                    receipt_date: getVal('receipt_date'),
                };

                fetch('{{ route('admin.receipts.preview') }}', {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    })
                    .then(r => r.text())
                    .then(html => {
                        document.getElementById('previewArea').innerHTML = html;
                    })
                    .catch(e => console.error('Preview error:', e));
            }

            function printPDF() {
                const data = {
                    receipt_number: getVal('receipt_number'),
                    payer_name: getVal('payer_name'),
                    amount_text: getVal('amount_text'),
                    description: getVal('description'),
                    package_price: getVal('package_price'),
                    receipt_date: getVal('receipt_date'),
                };

                const iframe = document.createElement('iframe');
                iframe.style.display = 'none';
                document.body.appendChild(iframe);

                const originalTitle = document.title;
                const safeFileName = 'Kuitansi_' + (data.payer_name || 'AlAhza');

                fetch('{{ route('admin.receipts.preview') }}', {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.text())
                    .then(html => {
                        iframe.contentDocument.write(html);
                        iframe.contentDocument.close();
                        document.title = safeFileName;
                        iframe.contentDocument.title = safeFileName;

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

            document.getElementById('receiptForm').addEventListener('input', updatePreview);
            document.getElementById('receiptForm').addEventListener('change', updatePreview);
            document.getElementById('receiptForm').addEventListener('input', function() {
                const btn = document.getElementById('printPdfBtn');
                if (btn) btn.disabled = false;
            });
            const amountField = document.getElementById('amount_text');
            if (amountField) {
                amountField.value = formatRupiah(amountField.value);
                updateTerbilang(amountField.value);
            }
            const packageField = document.getElementById('package_price');
            if (packageField) {
                packageField.value = formatRupiah(packageField.value);
            }
            updatePreview();
        </script>
    @endpush

@endsection
