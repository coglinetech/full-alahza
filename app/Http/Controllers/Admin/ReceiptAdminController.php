<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Receipt;
use Illuminate\Http\Request;

class ReceiptAdminController extends Controller
{
    public function index()
    {
        $items = Receipt::latest()->paginate(20);
        return view('admin.receipts.index', ['items' => $items]);
    }

    public function create()
    {
        $nextId = Receipt::max('id') ? Receipt::max('id') + 1 : 1;
        $nextNumber = sprintf('%03d', $nextId);
        return view('admin.receipts.create', ['nextNumber' => $nextNumber]);
    }

    public function edit(Receipt $receipt)
    {
        return view('admin.receipts.edit', ['receipt' => $receipt, 'displayNumber' => $receipt->display_receipt_number]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'receipt_number' => 'nullable|string|max:255',
            'payer_name' => 'required|string|max:255',
            'amount_text' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'package_price' => 'nullable|string|max:255',
            'receipt_date' => 'required|date',
        ]);

        $data['receipt_number'] = $this->normalizeReceiptNumber($data['receipt_number'] ?? '');
        $data['admin_name'] = auth()->user()->name;
        $data['admin_name'] = '';

        Receipt::create($data);

        return redirect()->route('admin.receipts.index')->with('success', 'Kuitansi berhasil disimpan.');
    }

    public function update(Request $request, Receipt $receipt)
    {
        $data = $request->validate([
            'receipt_number' => 'nullable|string|max:255',
            'payer_name' => 'required|string|max:255',
            'amount_text' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'package_price' => 'nullable|string|max:255',
            'receipt_date' => 'required|date',
        ]);

        $data['receipt_number'] = $this->normalizeReceiptNumber($data['receipt_number'] ?? '');
<<<<<<< HEAD
        $data['admin_name'] = auth()->user()->name;
=======
        $data['admin_name'] = '';
>>>>>>> projek_kedua/master

        $receipt->update($data);

        return redirect()->route('admin.receipts.index')->with('success', 'Kuitansi berhasil diperbarui.');
    }

    public function preview(Request $request)
    {
        $data = $request->all();
        return view('admin.receipts.preview', ['data' => $data]);
    }

<<<<<<< HEAD
=======
    public function previewContent(Request $request)
    {
        $data = $request->all();
        return view('admin.receipts.preview-content', ['data' => $data]);
    }

>>>>>>> projek_kedua/master
    public function show(Receipt $receipt)
    {
        return view('admin.receipts.preview', ['data' => $receipt->toArray()]);
    }

    public function destroy(Receipt $receipt)
    {
        $receipt->delete();

        return redirect()->route('admin.receipts.index')->with('success', 'Kuitansi berhasil dihapus.');
    }

    private function normalizeReceiptNumber(?string $value): string
    {
        $value = trim((string) $value);

        if ($value === '') {
            $nextId = Receipt::max('id') ? Receipt::max('id') + 1 : 1;
            return sprintf('[Nomor %03d]', $nextId);
        }

        if (preg_match('/^\[Nomor\s*\d+\]$/', $value)) {
            return $value;
        }

        if (preg_match('/^\d+$/', $value)) {
            return sprintf('[Nomor %03d]', (int) $value);
        }

        return $value;
    }

    private function stripReceiptNumber(?string $value): string
    {
        $value = trim((string) $value);

        if (preg_match('/^\[Nomor\s*0*([0-9]+)\]$/', $value, $matches)) {
            return $matches[1];
        }

        return $value;
    }
}
