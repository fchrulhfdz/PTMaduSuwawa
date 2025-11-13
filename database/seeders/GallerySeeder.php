<?php
// database/seeders/GallerySeeder.php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class GallerySeeder extends Seeder
{
    public function run()
    {
        // Kosongkan table gallery terlebih dahulu
        Gallery::truncate();

        // Data untuk foto gallery
        $photos = [
            [
                'title' => 'Proses Panen Madu Tradisional',
                'description' => 'Proses memanen madu langsung dari sarang lebah di hutan Suwawa dengan cara tradisional',
                'file_path' => 'gallery/photos/gallery1.jpg',
                'order' => 1
            ],
            [
                'title' => 'Penyaringan Madu Murni',
                'description' => 'Proses penyaringan madu untuk memastikan kemurnian dan kualitas terbaik',
                'file_path' => 'gallery/photos/gallery2.jpg',
                'order' => 2
            ],
            [
                'title' => 'Kawasan Hutan Lebah Suwawa',
                'description' => 'Lokasi peternakan lebah alami di kawasan hutan Suwawa yang masih asri',
                'file_path' => 'gallery/photos/gallery3.jpg',
                'order' => 3
            ],
            [
                'title' => 'Pengemasan Produk Madu',
                'description' => 'Proses pengemasan madu dengan standar higienis dan kemasan yang menarik',
                'file_path' => 'gallery/photos/gallery4.jpg',
                'order' => 4
            ]
        ];

        // Data untuk video gallery
        $videos = [
            [
                'title' => 'Proses Panen Madu Lengkap',
                'description' => 'Dokumentasi lengkap proses panen madu tradisional dari awal hingga akhir',
                'file_path' => 'gallery/videos/video1.mp4',
                'order' => 1
            ],
            [
                'title' => 'Pengolahan dan Pengemasan Madu',
                'description' => 'Proses pengolahan madu mulai dari penyaringan hingga pengemasan produk akhir',
                'file_path' => 'gallery/videos/video2.mp4',
                'order' => 2
            ]
        ];

        $this->command->info('Membuat data foto gallery...');

        foreach ($photos as $photo) {
            Gallery::create(array_merge($photo, [
                'type' => 'photo',
                'is_active' => true
            ]));
            $this->command->info("Foto '{$photo['title']}' berhasil dibuat");
        }

        $this->command->info('Membuat data video gallery...');

        foreach ($videos as $video) {
            Gallery::create(array_merge($video, [
                'type' => 'video',
                'is_active' => true,
                'thumbnail_path' => 'gallery/thumbnails/' . pathinfo($video['file_path'], PATHINFO_FILENAME) . '_thumb.jpg'
            ]));
            $this->command->info("Video '{$video['title']}' berhasil dibuat");
        }

        $this->command->info('Gallery seeder berhasil dijalankan!');
        $this->command->info('Note: File gambar/video aktual perlu diupload manual melalui admin panel.');
    }
}