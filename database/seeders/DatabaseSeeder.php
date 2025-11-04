<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin Madu Suwawa',
            'email' => 'admin@madusuwawa.com',
            'password' => bcrypt('password123'),
        ]);

        // Site settings
        Setting::updateOrCreate(['key' => 'site_name'], ['value' => 'Madu Suwawa']);
        Setting::updateOrCreate(['key' => 'description'], ['value' => 'Madu asli berkualitas dari alam Suwawa yang kaya akan manfaat untuk kesehatan Anda. Kami menyediakan berbagai jenis madu murni yang diproses dengan standar kualitas terbaik.']);
        Setting::updateOrCreate(['key' => 'address'], ['value' => 'Suwawa, Bone Bolango, Gorontalo']);
        Setting::updateOrCreate(['key' => 'contact'], ['value' => '+62 812-3456-7890']);

        // Create sample products
        Product::create([
            'name' => 'Madu Hutan Asli',
            'category' => 'Madu Hutan',
            'price' => 150000,
            'stock' => 50,
            'description' => 'Madu hutan asli yang diambil langsung dari alam liar Suwawa. Kaya akan nutrisi dan antioksidan.',
        ]);

        Product::create([
            'name' => 'Madu Randu',
            'category' => 'Madu Budidaya',
            'price' => 120000,
            'stock' => 30,
            'description' => 'Madu randu dengan rasa yang lembut dan aroma khas. Cocok untuk sehari-hari.',
        ]);

        Product::create([
            'name' => 'Madu Kelengkeng',
            'category' => 'Madu Budidaya',
            'price' => 180000,
            'stock' => 25,
            'description' => 'Madu kelengkeng dengan aroma harum dan rasa manis yang khas. Kaya akan vitamin dan mineral.',
        ]);

        // Create sample testimonials
        Testimonial::create([
            'customer_name' => 'Ahmad Rizki',
            'customer_title' => 'Karyawan Swasta',
            'rating' => 5,
            'testimonial' => 'Madu Suwawa ini benar-benar original dan berkualitas. Keluarga saya sudah konsumsi rutin selama 6 bulan, badan jadi lebih fit dan jarang sakit. Pelayanannya juga cepat dan ramah!',
            'is_active' => true,
            'is_featured' => true,
        ]);

        Testimonial::create([
            'customer_name' => 'Siti Aminah',
            'customer_title' => 'Ibu Rumah Tangga',
            'rating' => 5,
            'testimonial' => 'Anak-anak saya sangat suka madu ini, tidak terlalu manis dan teksturnya pas. Sejak rutin minum madu Suwawa, nafsu makan anak-anak meningkat dan daya tahan tubuh mereka jadi lebih baik.',
            'is_active' => true,
            'is_featured' => true,
        ]);

        Testimonial::create([
            'customer_name' => 'Budi Santoso',
            'customer_title' => 'Pegawai Negeri',
            'rating' => 4,
            'testimonial' => 'Kualitas madu sangat bagus, kemasan rapi, dan pengiriman tepat waktu. Hanya saja harganya sedikit mahal, tapi sebanding dengan kualitas yang diberikan. Recommended!',
            'is_active' => true,
            'is_featured' => false,
        ]);

        Testimonial::create([
            'customer_name' => 'Maya Sari',
            'customer_title' => 'Pengusaha Kecil',
            'rating' => 5,
            'testimonial' => 'Saya menggunakan madu Suwawa untuk campuran produk minuman sehat saya. Konsumen sangat puas dengan rasa dan kualitasnya. Terima kasih Madu Suwawa!',
            'is_active' => true,
            'is_featured' => true,
        ]);

        Testimonial::create([
            'customer_name' => 'Dewi Lestari',
            'customer_title' => 'Guru',
            'rating' => 5,
            'testimonial' => 'Sebagai guru, saya butuh stamina yang prima. Sejak rutin konsumsi madu Suwawa setiap pagi, energi saya lebih terjaga sepanjang hari. Rasanya juga enak, tidak terlalu pekat.',
            'is_active' => true,
            'is_featured' => false,
        ]);

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('👤 Admin User: admin@madusuwawa.com / password123');
        $this->command->info('🍯 Products: 3 sample products created');
        $this->command->info('⭐ Testimonials: 5 sample testimonials created');
        $this->command->info('⚙️ Settings: Site configuration added');
    }
}