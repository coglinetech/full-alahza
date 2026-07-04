<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            ['category' => 'persyaratan', 'sort_order' => 1, 'question' => 'Apa saja syarat untuk mendaftar umroh?', 'answer' => 'Syarat mendaftar umroh meliputi: (1) Paspor aktif dengan masa berlaku minimal 8 bulan, (2) KTP dan Kartu Keluarga, (3) Foto terbaru ukuran 3×4 dan 4×6 dengan background putih, (4) Buku nikah (untuk suami-istri), (5) Akte kelahiran (untuk anak), (6) Bukti pelunasan biaya paket.'],
            ['category' => 'dokumen',      'sort_order' => 2, 'question' => 'Dokumen apa saja yang perlu disiapkan?', 'answer' => 'Dokumen utama: paspor aktif, KTP, Kartu Keluarga, foto background putih, buku nikah, dan Surat Keterangan Sehat. Tim kami akan membantu pengurusan semua dokumen.'],
            ['category' => 'jadwal',       'sort_order' => 3, 'question' => 'Kapan jadwal keberangkatan terdekat?', 'answer' => 'Jadwal keberangkatan kami bervariasi setiap bulan. Hubungi tim kami via WhatsApp untuk info jadwal terbaru. Daftarkan diri lebih awal karena kuota setiap grup terbatas.'],
            ['category' => 'pembayaran',   'sort_order' => 4, 'question' => 'Apakah bisa bayar secara cicilan?', 'answer' => 'Ya, kami menyediakan skema cicilan fleksibel. DP 30–50% dari total biaya, sisa dilunasi sebelum keberangkatan sesuai kesepakatan. Hubungi kami untuk mendiskusikan skema terbaik.'],
            ['category' => 'pembatalan',   'sort_order' => 5, 'question' => 'Bagaimana kebijakan pembatalan dan refund?', 'answer' => 'Kebijakan refund mempertimbangkan waktu pembatalan dan biaya yang telah dikeluarkan. Pembatalan >60 hari mendapat refund terbesar. Detail lengkap ada di perjanjian saat pendaftaran.'],
            ['category' => 'umum',         'sort_order' => 6, 'question' => 'Apakah Al-Ahza memiliki izin resmi dari Kemenag?', 'answer' => 'Ya, Al-Ahza terdaftar sebagai PPIU resmi dari Kementerian Agama RI. Nomor izin dapat dicek di situs resmi Kemenag RI.'],
            ['category' => 'umum',         'sort_order' => 7, 'question' => 'Apakah ada bimbingan manasik sebelum keberangkatan?', 'answer' => 'Tentu! Kami menyelenggarakan manasik intensif beberapa pertemuan, mencakup tata cara ibadah, doa-doa, fikih ibadah, serta persiapan fisik dan mental. Wajib diikuti semua jamaah.'],
            ['category' => 'umum',         'sort_order' => 8, 'question' => 'Bagaimana jika saya pertama kali melakukan umroh?', 'answer' => 'Tidak perlu khawatir! Muthawif kami yang berpengalaman mendampingi dari awal hingga akhir. Manasik pra-keberangkatan mempersiapkan Anda secara lengkap. Kami pastikan Anda nyaman dan aman.'],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                $faq
            );
        }
    }
}