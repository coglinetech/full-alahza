<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ImportQuranSql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quran:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Tanzil Quran SQL files (Uthmani and Indonesian Translation) into the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai proses import file SQL Quran Tanzil...');

        $files = [
            database_path('sql/quran-uthmani.sql') => 'Teks Arab Uthmani',
            database_path('sql/id.indonesian.sql') => 'Terjemahan Kemenag RI (Indonesia)',
        ];

        foreach ($files as $file => $name) {
            if (!File::exists($file)) {
                $this->error("File {$file} tidak ditemukan! Pastikan file berada di database/sql/");
                continue;
            }

            $this->info("Sedang membaca file: {$name}...");
            $sql = File::get($file);
            
            // Clean up create database instructions which might crash in sqlite
            // By replacing them or just execute directly
            // Tanzil SQLs have "CREATE DATABASE" which we don't want.
            $sql = preg_replace('/CREATE DATABASE IF NOT EXISTS `quran`.*?;/i', '', $sql);
            $sql = preg_replace('/USE `quran`;/i', '', $sql);
            
            $this->info("Sedang mengeksekusi import untuk: {$name}...");
            
            try {
                DB::unprepared($sql);
                $this->info("✅ Berhasil mengimpor: {$name}");
            } catch (\Exception $e) {
                $this->error("❌ Gagal mengimpor {$name}. Error: " . $e->getMessage());
            }
        }

        $this->info('🎉 Proses import Quran selesai.');
    }
}
