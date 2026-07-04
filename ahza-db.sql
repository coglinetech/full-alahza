-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 14, 2026 at 03:57 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ahza-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint UNSIGNED NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('persyaratan','dokumen','jadwal','pembayaran','pembatalan','umum') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'umum',
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `category`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Apa saja syarat untuk mendaftar umroh?', 'Syarat mendaftar umroh meliputi: (1) Paspor aktif dengan masa berlaku minimal 8 bulan, (2) KTP dan Kartu Keluarga, (3) Foto terbaru ukuran 3×4 dan 4×6 dengan background putih, (4) Buku nikah (untuk suami-istri), (5) Akte kelahiran (untuk anak), (6) Bukti pelunasan biaya paket.', 'persyaratan', 1, 1, '2026-03-31 19:18:54', '2026-03-31 19:18:54'),
(2, 'Dokumen apa saja yang perlu disiapkan?', 'Dokumen utama: paspor aktif, KTP, Kartu Keluarga, foto background putih, buku nikah, dan Surat Keterangan Sehat. Tim kami akan membantu pengurusan semua dokumen.', 'dokumen', 2, 1, '2026-03-31 19:18:54', '2026-03-31 19:18:54'),
(3, 'Kapan jadwal keberangkatan terdekat?', 'Jadwal keberangkatan kami bervariasi setiap bulan. Hubungi tim kami via WhatsApp untuk info jadwal terbaru. Daftarkan diri lebih awal karena kuota setiap grup terbatas.', 'jadwal', 3, 1, '2026-03-31 19:18:54', '2026-03-31 19:18:54'),
(4, 'Apakah bisa bayar secara cicilan?', 'Ya, kami menyediakan skema cicilan fleksibel. DP 30–50% dari total biaya, sisa dilunasi sebelum keberangkatan sesuai kesepakatan. Hubungi kami untuk mendiskusikan skema terbaik.', 'pembayaran', 4, 1, '2026-03-31 19:18:54', '2026-03-31 19:18:54'),
(5, 'Bagaimana kebijakan pembatalan dan refund?', 'Kebijakan refund mempertimbangkan waktu pembatalan dan biaya yang telah dikeluarkan. Pembatalan >60 hari mendapat refund terbesar. Detail lengkap ada di perjanjian saat pendaftaran.', 'pembatalan', 5, 1, '2026-03-31 19:18:54', '2026-03-31 19:18:54'),
(6, 'Apakah Al-Ahza memiliki izin resmi dari Kemenag?', 'Ya, Al-Ahza terdaftar sebagai PPIU resmi dari Kementerian Agama RI. Nomor izin dapat dicek di situs resmi Kemenag RI.', 'umum', 6, 1, '2026-03-31 19:18:54', '2026-03-31 19:18:54'),
(7, 'Apakah ada bimbingan manasik sebelum keberangkatan?', 'Tentu! Kami menyelenggarakan manasik intensif beberapa pertemuan, mencakup tata cara ibadah, doa-doa, fikih ibadah, serta persiapan fisik dan mental. Wajib diikuti semua jamaah.', 'umum', 7, 1, '2026-03-31 19:18:54', '2026-03-31 19:18:54'),
(8, 'Bagaimana jika saya pertama kali melakukan umroh?', 'Tidak perlu khawatir! Muthawif kami yang berpengalaman mendampingi dari awal hingga akhir. Manasik pra-keberangkatan mempersiapkan Anda secara lengkap. Kami pastikan Anda nyaman dan aman.', 'umum', 8, 1, '2026-03-31 19:18:54', '2026-03-31 19:18:54');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_images`
--

CREATE TABLE `gallery_images` (
  `id` bigint UNSIGNED NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` enum('keberangkatan','ibadah','perjalanan','hotel','lainnya') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'lainnya',
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallery_images`
--

INSERT INTO `gallery_images` (`id`, `image_path`, `caption`, `category`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(11, 'gallery/23d350ca-f749-407c-a443-97d5ebb1a106.jpg', NULL, 'lainnya', 0, 1, '2026-04-13 00:29:18', '2026-04-13 20:34:42'),
(12, 'gallery/ced8c7b0-f4b1-4cdf-b88e-d3cd20e35c55.jpg', NULL, 'lainnya', 0, 1, '2026-04-13 00:29:28', '2026-04-13 00:29:28'),
(13, 'gallery/9766b8dc-0f43-42e5-80c2-6bc85435ac3a.jpg', NULL, 'lainnya', 0, 1, '2026-04-13 00:29:36', '2026-04-13 00:29:36'),
(14, 'gallery/faf3c574-352f-48cc-ba9a-154b8aaeaa05.jpg', NULL, 'lainnya', 0, 1, '2026-04-13 00:29:45', '2026-04-13 00:29:45');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_01_021602_create_packages_table', 1),
(5, '2026_04_01_021607_create_testimonials_table', 1),
(6, '2026_04_01_021611_create_gallery_images_table', 1),
(7, '2026_04_01_021616_create_faqs_table', 1),
(8, '2026_04_02_023244_create_add_image_path_to_packages_table', 2),
(9, '2026_04_07_073410_create_site_settings_table', 3),
(10, '2026_04_07_080322_add_role_to_users_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('umroh_reguler','umroh_plus') COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_start` decimal(15,2) NOT NULL,
  `currency` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'IDR',
  `highlights` json DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `destination` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `name`, `slug`, `category`, `duration`, `price_start`, `currency`, `highlights`, `description`, `destination`, `image_path`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Umroh', 'umroh-reguler', 'umroh_reguler', '10 Hari', 33500000.00, 'IDR', '[\"Pesawat PP langsung\", \"Hotel bintang 4 dekat Masjidil Haram\", \"Visa umroh & asuransi perjalanan\", \"Makan 3× sehari, Muthawif berpengalaman\", \"Manasik lengkap & ziarah Madinah\", \"Hotel Bintang Cihuy\"]', 'Paket umroh reguler dengan fasilitas lengkap dan terjangkau.', NULL, 'packages/Kl6vxiC5oSmI6z0t6L4spiNRCwgIhAwS9VcrS0pG.jpg', 1, 1, '2026-03-31 19:18:53', '2026-04-13 00:19:46'),
(2, 'Paket Umroh', 'umroh-plus', 'umroh_plus', '9 Hari', 28000000.00, 'IDR', '[\"Semua fasilitas paket reguler\", \"Destinasi tambahan (Turki/Dubai/Mesir/Aqsa)\", \"City tour & guide lokal berpengalaman\", \"Hotel bintang 4–5 di semua destinasi\", \"Dokumentasi perjalanan profesional\"]', 'Umroh plus destinasi wisata Islami mancanegara.', 'Turki / Dubai / Mesir / Aqsa', 'packages/I8puXOGD9Bq9Gqx8P2BXU6q6m9OCEVlkjemEnsQX.jpg', 1, 2, '2026-03-31 19:18:53', '2026-04-13 00:21:24'),
(3, 'Umroh Ramadhan', 'umroh-ramadhan', 'umroh_plus', '11 Hari', 35500000.00, 'IDR', '[\"Jadwal khusus bulan Ramadhan\", \"Bimbingan manasik pra-keberangkatan\", \"Pendampingan penuh selama di Tanah Suci\", \"Asuransi jiwa & kesehatan perjalanan\", \"Konsultasi & pengurusan dokumen lengkap\"]', 'Paket umroh khusus Ramadhan dengan pendampingan intensif.', NULL, 'packages/FeADY54CYonjUT6LsYqbbIG8IQ0h8ADAsYX25Ir7.jpg', 1, 3, '2026-03-31 19:18:53', '2026-04-13 00:22:28');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('2q6ZP7y3dhvTW4ib4KjGT9WjEerHzNVEjL4heQsr', 1, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 8.0.0; SM-G955U Build/R16NW) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZ3NKQnZsYjJTc0dubFpoVjg3eHpkczM1N0RLeEp1SVY1R2F5Z090byI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9zZXNzaW9uLWNoZWNrIjtzOjU6InJvdXRlIjtzOjE5OiJhZG1pbi5zZXNzaW9uLmNoZWNrIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1776135593),
('8QEHqCcYlYbR8Jmw5RsKWOA15BvGtsomJpc3CtyZ', 1, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 8.0.0; SM-G955U Build/R16NW) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibk9wZTJoSkhJV2ZQeWFUNXFDT1VaY0FVYm9NbFMxVXcyQ0wzZWdaaSI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo0MToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL3Nlc3Npb24tY2hlY2siO3M6NToicm91dGUiO3M6MTk6ImFkbWluLnNlc3Npb24uY2hlY2siO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1776135764),
('DCf22hEwZ0qiMvTuIepmTJWonmn58KgiLHpW08I3', 1, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 8.0.0; SM-G955U Build/R16NW) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNWlkUkdsckFTa1BGS1FhNEtLa3l2MExwRmlyZVFQZzdOdG5qcUE0YiI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo0MToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL3Nlc3Npb24tY2hlY2siO3M6NToicm91dGUiO3M6MTk6ImFkbWluLnNlc3Npb24uY2hlY2siO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1776135831),
('dIwZbxzpxc9a5vbbmsuVfFOJhx8um9yimamymxrx', 1, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 8.0.0; SM-G955U Build/R16NW) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRTJET3U2TTFiQ1hPT1RHd093RHU4Q2hLUXNnQWJlaUhMMjVUZWpRSiI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo0MToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL3Nlc3Npb24tY2hlY2siO3M6NToicm91dGUiO3M6MTk6ImFkbWluLnNlc3Npb24uY2hlY2siO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1776135759),
('MZ0nX0TCTSNpINHomjijTZ96JknsQZpx3lAPjIx9', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZnBmTHlmNndMbFpic0NYdmVyZmtvalkzcDB3elZWR2piYXpkcXlXbiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9zZXNzaW9uLWNoZWNrIjtzOjU6InJvdXRlIjtzOjE5OiJhZG1pbi5zZXNzaW9uLmNoZWNrIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1776139025),
('oOtEnF7JhxnNLgkKDSrKdj5fememZkVuknPtToId', 1, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 8.0.0; SM-G955U Build/R16NW) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTkFlOGpRN1dWVE5PcVFqQnozbnp4OU45T3ZOZVZtd3dhYXg5emZJZSI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo0MToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL3Nlc3Npb24tY2hlY2siO3M6NToicm91dGUiO3M6MTk6ImFkbWluLnNlc3Npb24uY2hlY2siO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1776135891),
('rcw1mdOtk9P6PGLl279Gtprqje1fh1uZ7ldSMWwn', 1, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWWtZRjE5WUNIdXBHcTlnUnF3VnBmWkJIYXo2elF3U3FkVGVPeGlJVSI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo0MToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL3Nlc3Npb24tY2hlY2siO3M6NToicm91dGUiO3M6MTk6ImFkbWluLnNlc3Npb24uY2hlY2siO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1776135926),
('tohVKtFYfUVyUFt5eCL8LYVG8wrDFx8XkQDZTv3T', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiT21NS3RqNlRCUXM4WlVHOEwxRXB0SXB1SzFOODRXWDc2c0t2NFRkZyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9zZXNzaW9uLWNoZWNrIjtzOjU6InJvdXRlIjtzOjE5OiJhZG1pbi5zZXNzaW9uLmNoZWNrIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1776139016),
('vNE4qCU7vkvRI2OYa6tzwFO4kX6SyxlXroucEgVr', 1, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoib1hXTHNpVDNMb2JhNDc3NFhVSUFOV20yT2xzRjNrdzlQaTk0TFlUMSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9zZXNzaW9uLWNoZWNrIjtzOjU6InJvdXRlIjtzOjE5OiJhZG1pbi5zZXNzaW9uLmNoZWNrIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1776136128),
('WvJ5Sdr1IHx2tqmS0wRK3uG8ZW5oXFqLa8trWbW1', 1, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYmx1eXpJeUpVdVlCbVZYT01xcE9mOWx3b2J2dUJpeEhjZzZRNnFMRiI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo0MToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL3Nlc3Npb24tY2hlY2siO3M6NToicm91dGUiO3M6MTk6ImFkbWluLnNlc3Npb24uY2hlY2siO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1776136001);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'about_image_path', 'about/ujxNVLfHFZatDbcuU2Zl3gh4U6vItDObHjtdwQFe.jpg', '2026-04-07 23:58:28', '2026-04-10 00:18:39'),
(2, 'about_jamaah_count', '1000', '2026-04-07 23:58:28', '2026-04-09 02:10:38'),
(3, 'about_tahun_berdiri', '2020', '2026-04-07 23:58:28', '2026-04-09 02:10:38'),
(4, 'about_destinasi_count', '12', '2026-04-07 23:58:28', '2026-04-07 23:58:28'),
(5, 'about_rating_pct', '99', '2026-04-07 23:58:28', '2026-04-09 02:10:38');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `package_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` year DEFAULT NULL,
  `rating` tinyint NOT NULL DEFAULT '5',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `city`, `photo`, `content`, `package_name`, `year`, `rating`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Praboti', 'Britania', NULL, 'Pelayanan sangat memuaskan, hotel dekat Masjidil Haram, ustadz membimbing dengan sabar dan penuh ilmu. Alhamdulillah, ibadah kami terasa sangat khusyuk dan berkesan.', 'Umroh Reguler', '2024', 5, 1, '2026-03-31 19:18:54', '2026-04-08 19:23:48'),
(2, 'Gib Run', 'Tasikmalaya', NULL, 'Alhamdulillah, perjalanan lancar dan sangat nyaman. Semua urusan dari visa hingga hotel diurus dengan profesional. Terima kasih banyak Al-Ahza!', 'Umroh Plus', '2024', 5, 1, '2026-03-31 19:18:54', '2026-04-08 19:23:57'),
(3, 'Saya Akan Kembali ke Solo', 'Soloverse', NULL, 'Pertama kali umroh dan semuanya diurus dengan sangat baik. Saya yang awam pun merasa aman dan terbimbing dari awal hingga akhir. Insya Allah berangkat lagi!', 'Umroh Reguler', '2023', 5, 1, '2026-03-31 19:18:54', '2026-04-08 19:25:17'),
(4, 'Kang KDM Mulyadi', 'Jabar Barat', NULL, 'Umroh plus premium-nya luar biasa! Hotel bintang 5, jalan kaki ke Masjidil Haram, pelayanan VIP yang benar-benar terasa. Sangat recommended untuk keluarga!', 'Umroh Plus Premium', '2023', 5, 1, '2026-03-31 19:18:54', '2026-04-08 19:23:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@alahza.com', 'admin', NULL, '$2y$12$z3G4owKXzjNkdhVLAQRSJeuPYjhUcZ85QWgIQrRsOjJKl/AtgcH3S', 'nTYpwFobWzrhq91SMZbLGNgbc8DBfXVr5XNuZZMyHO21NdjpGFZoeeRuTYQc', '2026-04-07 01:08:40', '2026-04-07 18:16:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `packages_slug_unique` (`slug`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `site_settings_key_unique` (`key`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `gallery_images`
--
ALTER TABLE `gallery_images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
