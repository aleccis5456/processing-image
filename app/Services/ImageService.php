<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Image;
use Illuminate\Support\Facades\Auth;

class ImageService
{
    public function show(int $id): Image{
        return Image::find($id);
    }

    public function processAndSave(object $image): array {
        [$with, $height] = getimagesize($image->getRealPath());
        $size = round($image->getSize() / 1024 / 1024, 2);
        $format = $image->getClientOriginalExtension();

        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);

        $data = [
            'user_id' => Auth::id(),
            'path' => '',
            'width' => $with,
            'height' => $height,
            'name' => $imageName,
            'size' => $size,
            'format' => $format,
            'image' => $image,
            'image_name' => $imageName,
        ];

        return $data;
    }

    public function deleteByNameAndFile(string $name){
        $image = Image::where('name', $name)->first();             
        try{
            if($image){
                $image->delete();
            }
            if(file_exists(public_path('images/' . $name))){
                unlink(public_path('images/' . $name));
            }
        }catch(\Exception $e){
            return false;
        }
        return true;
    }
}
