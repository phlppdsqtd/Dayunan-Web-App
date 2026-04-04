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
                    'images/galleries/lounge1.jpg',
                    'images/galleries/lounge2.jpg',
                    'images/galleries/lounge3.jpg',
                ],
            ],
            [
                'name' => 'Standard Room',
                'description' => 'A simple and comfortable room for rest.',
                'images' => [
                    'images/galleries/standard1.jpg',
                    'images/galleries/standard2.jpg',
                    'images/galleries/standard3.jpg',
                ],
            ],
            [
                'name' => 'Barkada Room',
                'description' => 'A shared space designed for groups.',
                'images' => [
                    'images/galleries/barkada1.jpg',
                    'images/galleries/barkada2.jpg',
                    'images/galleries/barkada3.jpg',
                ],
            ],
            [
                'name' => 'Master Bedroom',
                'description' => 'A private and more spacious room for a slower stay.',
                'images' => [
                    'images/galleries/master1.jpg',
                    'images/galleries/master2.jpg',
                    'images/galleries/master3.jpg',
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