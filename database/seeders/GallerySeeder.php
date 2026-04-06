<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $galleries = [
            [
                'name' => 'Lounge Area',
                'description' => 'A relaxed open space for gathering and quiet afternoons.',
                'images' => [
                    'galleries/lounge1.jpg',
                    'galleries/lounge2.jpg',
                    'galleries/lounge3.jpg',
                ],
            ],
            [
                'name' => 'Standard Room',
                'description' => 'A simple and comfortable room for rest.',
                'images' => [
                    'galleries/standard1.jpg',
                    'galleries/standard2.jpg',
                    'galleries/standard3.jpg',
                ],
            ],
            [
                'name' => 'Barkada Room',
                'description' => 'A shared space designed for groups.',
                'images' => [
                    'galleries/barkada1.jpg',
                    'galleries/barkada2.jpg',
                    'galleries/barkada3.jpg',
                ],
            ],
            [
                'name' => 'Master Bedroom',
                'description' => 'A private and more spacious room for a slower stay.',
                'images' => [
                    'galleries/master1.jpg',
                    'galleries/master2.jpg',
                    'galleries/master3.jpg',
                ],
            ],
        ];

        foreach ($galleries as $galleryData) {
            $gallery = Gallery::firstOrCreate(
                ['name' => $galleryData['name']],
                ['description' => $galleryData['description']]
            );

            foreach ($galleryData['images'] as $imagePath) {
                GalleryImage::firstOrCreate([
                    'gallery_id' => $gallery->id,
                    'image' => $imagePath,
                ]);
            }
        }
    }
}