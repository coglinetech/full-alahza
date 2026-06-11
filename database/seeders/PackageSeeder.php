<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'name'        => 'Umroh Reguler',
                'slug'        => 'umroh-reguler',
                'category'    => 'umroh_reguler',
                'duration'    => '9 Hari / 12 Hari',
                'price_start' => 25000000,
                'highlights'  => [
                    'Pesawat PP langsung',
                    'Hotel bintang 4 dekat Masjidil Haram',
                    'Visa umroh & asuransi perjalanan',
                    'Makan 3× sehari, Muthawif berpengalaman',
                    'Manasik lengkap & ziarah Madinah',
                ],
                'description' => 'Paket umroh reguler dengan fasilitas lengkap dan terjangkau.',
                'sort_order'  => 1,
            ],
            [
                'name'        => 'Umroh Plus',
                'slug'        => 'umroh-plus',
                'category'    => 'umroh_plus',
                'duration'    => '12–15 Hari',
                'price_start' => 35000000,
                'highlights'  => [
                    'Semua fasilitas paket reguler',
                    'Destinasi tambahan (Turki/Dubai/Mesir/Aqsa)',
                    'City tour & guide lokal berpengalaman',
                    'Hotel bintang 4–5 di semua destinasi',
                    'Dokumentasi perjalanan profesional',
                ],
                'description' => 'Umroh plus destinasi wisata Islami mancanegara.',
                'destination' => 'Turki / Dubai / Mesir / Aqsa',
                'sort_order'  => 2,
            ],
            [
                'name'        => 'Umroh Ramadhan',
                'slug'        => 'umroh-ramadhan',
                'category'    => 'umroh_reguler',
                'duration'    => '12 Hari',
                'price_start' => 42000000,
                'highlights'  => [
                    'Jadwal khusus bulan Ramadhan',
                    'Buka puasa & sahur terkoordinasi di hotel',
                    'Pendampingan ibadah harian oleh pembimbing',
                    'Program qiyamul lail dan kajian tematik',
                    'Konsultasi & pengurusan dokumen lengkap',
                ],
                'description' => 'Paket umroh khusus Ramadhan dengan pendampingan intensif.',
                'sort_order'  => 3,
            ],
            [
                'name'        => 'Umroh Plus Premium',
                'slug'        => 'umroh-plus-premium',
                'category'    => 'umroh_plus',
                'duration'    => '15 Hari',
                'price_start' => 68000000,
                'highlights'  => [
                    'Hotel bintang 5 walking distance ke Masjidil Haram',
                    'Handling bandara prioritas dan terkoordinasi',
                    'VIP handling bandara & selama perjalanan',
                    'Private muthawif & tim pendamping eksklusif',
                    'Makan premium & transportasi privat',
                ],
                'description' => 'Umroh plus premium dengan fasilitas VIP terbaik.',
                'sort_order'  => 4,
            ],
        ];

        foreach ($packages as $pkg) {
            Package::updateOrCreate(
                ['slug' => $pkg['slug']],
                $pkg
            );
        }
    }
}