<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name'         => 'Hj. Siti Aminah',
                'city'         => 'Ciamis',
                'content'      => 'Pelayanan sangat memuaskan, hotel dekat Masjidil Haram, ustadz membimbing dengan sabar dan penuh ilmu. Alhamdulillah, ibadah kami terasa sangat khusyuk dan berkesan.',
                'package_name' => 'Umroh Reguler',
                'year'         => 2024,
                'rating'       => 5,
            ],
            [
                'name'         => 'Ust. Ahmad Fauzi',
                'city'         => 'Tasikmalaya',
                'content'      => 'Alhamdulillah, perjalanan lancar dan sangat nyaman. Semua urusan dari visa hingga hotel diurus dengan profesional. Terima kasih banyak Al-Ahza!',
                'package_name' => 'Umroh Plus',
                'year'         => 2024,
                'rating'       => 5,
            ],
            [
                'name'         => 'Ibu Neng Rika',
                'city'         => 'Bandung',
                'content'      => 'Pertama kali umroh dan semuanya diurus dengan sangat baik. Saya yang awam pun merasa aman dan terbimbing dari awal hingga akhir. Insya Allah berangkat lagi!',
                'package_name' => 'Umroh Reguler',
                'year'         => 2023,
                'rating'       => 5,
            ],
            [
                'name'         => 'Bpk. Dedi Mulyadi',
                'city'         => 'Banjar',
                'content'      => 'Umroh plus premium-nya luar biasa! Hotel bintang 5, jalan kaki ke Masjidil Haram, pelayanan VIP yang benar-benar terasa. Sangat recommended untuk keluarga!',
                'package_name' => 'Umroh Plus Premium',
                'year'         => 2023,
                'rating'       => 5,
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::updateOrCreate(
                [
                    'name' => $t['name'],
                    'city' => $t['city'],
                    'package_name' => $t['package_name'],
                    'year' => $t['year'],
                ],
                $t
            );
        }
    }
}