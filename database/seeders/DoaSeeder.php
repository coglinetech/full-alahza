<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doas = [
            [
                'kategori' => 'Umroh & Haji',
                'judul' => 'Doa Niat Umroh',
                'arab' => 'لَبَّيْكَ اللَّهُمَّ عُمْرَةً',
                'latin' => 'Labbaikallahumma \'umratan',
                'terjemahan' => 'Aku penuhi panggilan-Mu ya Allah untuk melaksanakan ibadah umroh.',
            ],
            [
                'kategori' => 'Umroh & Haji',
                'judul' => 'Doa Masuk Masjidil Haram & Melihat Ka\'bah',
                'arab' => 'اللَّهُمَّ أَنْتَ السَّلَامُ وَمِنْكَ السَّلَامُ، فَحَيِّنَا رَبَّنَا بِالسَّلَامِ. اللَّهُمَّ زِدْ هَذَا الْبَيْتَ تَشْرِيفًا وَتَعْظِيمًا وَتَكْرِيمًا وَمَهَابَةً، وَزِدْ مَنْ شَرَّفَهُ وَعَظَّمَهُ مِمَّنْ حَجَّهُ أَوْ اعْتَمَرَهُ تَشْرِيفًا وَتَعْظِيمًا وَتَكْرِيمًا وَبِرًّا',
                'latin' => 'Allahumma antas salaam waminkas salaam, fahayyina rabbana bis salaam. Allahumma zid haadzal baita tasyriifan wa ta\'zhiiman wa takriiman wa mahaabatan, wa zid man syarrafahu wa \'azzhamahu mimman hajjahu awi\'tamarahu tasyriifan wa ta\'zhiiman wa takriiman wa birran.',
                'terjemahan' => 'Ya Allah, Engkau adalah Dzat yang memberi keselamatan, dan dari-Mu lah segala keselamatan. Maka hidupkanlah kami ya Tuhan kami dengan keselamatan. Ya Allah, tambahkanlah pada rumah ini kemuliaan, keagungan, kehormatan, dan kewibawaan. Dan tambahkanlah kemuliaan, keagungan, kehormatan, dan kebaikan pada orang-orang yang memuliakan dan mengagungkannya dari kalangan orang-orang yang haji atau umrah.',
            ],
            [
                'kategori' => 'Umroh & Haji',
                'judul' => 'Doa Thawaf (Putaran 1 dan Doa Sapu Jagat)',
                'arab' => 'رَبَّنَا آتِنَا فِي الدُّنْيَا حَسَنَةً وَفِي الْآخِرَةِ حَسَنَةً وَقِنَا عَذَابَ النَّارِ',
                'latin' => 'Rabbanaa aatinaa fid-dunyaa hasanah wa fil-aakhirati hasanah wa qinaa \'adzaaban-naar',
                'terjemahan' => 'Ya Tuhan kami, berilah kami kebaikan di dunia dan kebaikan di akhirat dan peliharalah kami dari siksa neraka.',
            ],
            [
                'kategori' => 'Umroh & Haji',
                'judul' => 'Doa Sa\'i (Di Bukit Shafa & Marwah)',
                'arab' => 'إِنَّ الصَّفَا وَالْمَرْوَةَ مِنْ شَعَائِرِ اللَّهِ. أَبْدَأُ بِمَا بَدَأَ اللَّهُ بِهِ. لَا إِلَهَ إِلَّا اللَّهُ وَحْدَهُ لَا شَرِيكَ لَهُ، لَهُ الْمُلْكُ وَلَهُ الْحَمْدُ وَهُوَ عَلَى كُلِّ شَيْءٍ قَدِيرٌ، لَا إِلَهَ إِلَّا اللَّهُ وَحْدَهُ، أَنْجَزَ وَعْدَهُ، وَنَصَرَ عَبْدَهُ، وَهَزَمَ الْأَحْزَابَ وَحْدَهُ',
                'latin' => 'Innas-shafaa wal-marwata min sya\'aa\'irillah. Abda\'u bimaa bada\'allahu bihi. Laa ilaaha illallahu wahdahu laa syariika lahu, lahul mulku wa lahul hamdu wa huwa \'alaa kulli syai\'in qadiir, laa ilaaha illallahu wahdahu, anjaza wa\'dahu, wa nasara \'abdahu, wa hazamal ahzaaba wahdahu.',
                'terjemahan' => 'Sesungguhnya Shafa dan Marwah adalah sebahagian dari syi\'ar Allah. Aku memulai dengan apa yang Allah mulai. Tiada Tuhan selain Allah yang Maha Esa, tiada sekutu bagi-Nya. Bagi-Nya segala kerajaan dan bagi-Nya segala puji. Dia Maha Kuasa atas segala sesuatu. Tiada Tuhan selain Allah yang Maha Esa, Dia telah menepati janji-Nya, menolong hamba-Nya dan menghancurkan musuh-musuh-Nya sendirian.',
            ],
            [
                'kategori' => 'Umroh & Haji',
                'judul' => 'Doa Minum Air Zam-zam',
                'arab' => 'اللَّهُمَّ إِنِّي أَسْأَلُكَ عِلْمًا نَافِعًا، وَرِزْقًا وَاسِعًا، وَشِفَاءً مِنْ كُلِّ دَاءٍ',
                'latin' => 'Allahumma innii as\'aluka \'ilman naafi\'an, wa rizqan waasi\'an, wa syifaa\'an min kulli daa\'in.',
                'terjemahan' => 'Ya Allah, sesungguhnya aku memohon kepada-Mu ilmu yang bermanfaat, rezeki yang luas, dan kesembuhan dari segala penyakit.',
            ],
            [
                'kategori' => 'Doa Safar',
                'judul' => 'Doa Naik Kendaraan',
                'arab' => 'سُبْحَانَ الَّذِي سَخَّرَ لَنَا هَذَا وَمَا كُنَّا لَهُ مُقْرِنِينَ. وَإِنَّا إِلَى رَبِّنَا لَمُنْقَلِبُونَ',
                'latin' => 'Subhaanalladzii sakhkhara lanaa haadzaa wa maa kunnaa lahu muqriniin. Wa innaa ilaa rabbinaa lamunqalibuun.',
                'terjemahan' => 'Maha Suci Tuhan yang telah menundukkan semua ini bagi kami padahal kami sebelumnya tidak mampu menguasainya, dan sesungguhnya kami akan kembali kepada Tuhan kami.',
            ],
            [
                'kategori' => 'Doa Safar',
                'judul' => 'Doa Singgah di Suatu Tempat',
                'arab' => 'أَعُوذُ بِكَلِمَاتِ اللَّهِ التَّامَّاتِ مِنْ شَرِّ مَا خَلَقَ',
                'latin' => 'A\'uudzu bikalimaatillahit-taammaati min syarri maa khalaq.',
                'terjemahan' => 'Aku berlindung dengan kalimat-kalimat Allah yang sempurna dari kejahatan makhluk yang diciptakan-Nya.',
            ],
            [
                'kategori' => 'Doa Harian',
                'judul' => 'Sayyidul Istighfar',
                'arab' => 'اللَّهُمَّ أَنْتَ رَبِّي لَا إِلَهَ إِلَّا أَنْتَ خَلَقْتَنِي وَأَنَا عَبْدُكَ وَأَنَا عَلَى عَهْدِكَ وَوَعْدِكَ مَا اسْتَطَعْتُ أَعُوذُ بِكَ مِنْ شَرِّ مَا صَنَعْتُ أَبُوءُ لَكَ بِنِعْمَتِكَ عَلَيَّ وَأَبُوءُ لَكَ بِذَنْبِي فَاغْفِرْ لِي فَإِنَّهُ لَا يَغْفِرُ الذُّنُوبَ إِلَّا أَنْتَ',
                'latin' => 'Allahumma anta rabbii laa ilaaha illaa anta khalaqtanii wa anaa \'abduka wa anaa \'alaa \'ahdika wa wa\'dika masta-tha\'tu a\'uudzu bika min syarri maa shana\'tu abuu-u laka bini\'matika \'alayya wa abuu-u laka bidzanbii faghfir lii fa-innahu laa yaghfirudz dzunuuba illaa anta.',
                'terjemahan' => 'Ya Allah, Engkau adalah Tuhanku. Tidak ada Tuhan yang berhak disembah selain Engkau. Engkau yang menciptakanku dan aku adalah hamba-Mu. Aku senantiasa berada di atas janji-Mu semampuku. Aku berlindung kepada-Mu dari keburukan yang telah aku perbuat. Aku mengakui nikmat-Mu yang diberikan kepadaku dan aku mengakui dosaku, maka ampunilah aku. Sesungguhnya tidak ada yang dapat mengampuni dosa-dosa selain Engkau.',
            ],
            [
                'kategori' => 'Doa Harian',
                'judul' => 'Doa Keluar Rumah',
                'arab' => 'بِسْمِ اللَّهِ تَوَكَّلْتُ عَلَى اللَّهِ لَا حَوْلَ وَلَا قُوَّةَ إِلَّا بِاللَّهِ',
                'latin' => 'Bismillaahi tawakkaltu \'alallaahi laa hawla wa laa quwwata illaa billaah.',
                'terjemahan' => 'Dengan nama Allah, aku bertawakal kepada Allah, tiada daya dan kekuatan kecuali dengan pertolongan Allah.',
            ],
            [
                'kategori' => 'Doa Harian',
                'judul' => 'Doa Masuk Rumah',
                'arab' => 'بِسْمِ اللَّهِ وَلَجْنَا وَبِسْمِ اللَّهِ خَرَجْنَا وَعَلَى رَبِّنَا تَوَكَّلْنَا',
                'latin' => 'Bismillahi walajnaa wa bismillaahi kharajnaa wa \'alaa rabbinaa tawakkalnaa.',
                'terjemahan' => 'Dengan nama Allah kami masuk, dengan nama Allah kami keluar, dan hanya kepada Tuhan kami kami bertawakal.',
            ],
            [
                'kategori' => 'Doa Harian',
                'judul' => 'Doa Sebelum Tidur',
                'arab' => 'بِاسْمِكَ اللَّهُمَّ أَمُوتُ وَأَحْيَا',
                'latin' => 'Bismikallaahumma amuutu wa ahyaa.',
                'terjemahan' => 'Dengan nama-Mu ya Allah aku mati dan aku hidup.',
            ],
            [
                'kategori' => 'Doa Harian',
                'judul' => 'Doa Bangun Tidur',
                'arab' => 'الْحَمْدُ لِلَّهِ الَّذِي أَحْيَانَا بَعْدَ مَا أَمَاتَنَا وَإِلَيْهِ النُّشُورُ',
                'latin' => 'Alhamdu lillaahil-ladzii ahyaanaa ba\'da maa amaatanaa wa ilaihin-nusyuur.',
                'terjemahan' => 'Segala puji bagi Allah yang telah menghidupkan kami setelah menidurkan kami, dan hanya kepada-Nya lah kami kembali dibangkitkan.',
            ],
        ];

        foreach ($doas as $doa) {
            $doa['created_at'] = now();
            $doa['updated_at'] = now();
            DB::table('doas')->insert($doa);
        }
    }
}
