<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Image;

class ImageRepository
{
    public function create($data) :Image{        
        return Image::create([
            'user_id' => $data['user_id'],
            'original_image_id' => $data['original_image_id'] ?? null,
            'path' => '',            
            'width' => $data['width'],
            'height' => $data['height'],
            'name' => $data['image_name'],
            'x' => 0,
            'y' => 0,
            'size' => $data['size'],
            'format' => $data['format'],
            'rotate' => 0,
            'filter' => false,
        ]);
    }
}
