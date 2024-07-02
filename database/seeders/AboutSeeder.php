<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\About;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        About::create([
            'judul_website' => 'BUTTHISMINE',
            'logo' => 'logo.png',
            'deskripsi' => 'This is the description of the website.',
            'alamat' => '1234 Street Name, City, Country',
            'email' => 'info@website.com',
            'telepon' => '123-456-7890',
            'atas_nama' => 'Jarot',
            'no_rekening' => '1234567890',
        ]);
    }
}
