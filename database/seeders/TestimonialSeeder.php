<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'customer_name' => 'Ahmad Rizki',
                'customer_title' => 'Karyawan Swasta',
                'rating' => 5,
                'testimonial' => 'Madu Suwawa ini benar-benar original dan berkualitas. Keluarga saya sudah konsumsi rutin selama 6 bulan, badan jadi lebih fit dan jarang sakit. Pelayanannya juga cepat dan ramah!',
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'customer_name' => 'Siti Aminah',
                'customer_title' => 'Ibu Rumah Tangga',
                'rating' => 5,
                'testimonial' => 'Anak-anak saya sangat suka madu ini, tidak terlalu manis dan teksturnya pas. Sejak rutin minum madu Suwawa, nafsu makan anak-anak meningkat dan daya tahan tubuh mereka jadi lebih baik.',
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'customer_name' => 'Budi Santoso',
                'customer_title' => 'Pegawai Negeri',
                'rating' => 4,
                'testimonial' => 'Kualitas madu sangat bagus, kemasan rapi, dan pengiriman tepat waktu. Hanya saja harganya sedikit mahal, tapi sebanding dengan kualitas yang diberikan. Recommended!',
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'customer_name' => 'Maya Sari',
                'customer_title' => 'Pengusaha Kecil',
                'rating' => 5,
                'testimonial' => 'Saya menggunakan madu Suwawa untuk campuran produk minuman sehat saya. Konsumen sangat puas dengan rasa dan kualitasnya. Terima kasih Madu Suwawa!',
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'customer_name' => 'Dewi Lestari',
                'customer_title' => 'Guru',
                'rating' => 5,
                'testimonial' => 'Sebagai guru, saya butuh stamina yang prima. Sejak rutin konsumsi madu Suwawa setiap pagi, energi saya lebih terjaga sepanjang hari. Rasanya juga enak, tidak terlalu pekat.',
                'is_active' => true,
                'is_featured' => false,
            ]
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }

        $this->command->info('Testimonial sample data created successfully!');
    }
}