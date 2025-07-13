<?php

namespace App\Services;

use App\Repositories\ImageRepository;
use App\Services\ImageService;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class TransformService
{
    public function __construct(
        protected ImageRepository $imageRepository,
        protected ImageService $imageService
        ) {}

    public function transform(object $image, array $request)
    {                
        $manager = new ImageManager(new Driver());
        $img = $manager->read(public_path('images/' . $image->name));

        $with = $request['transformations']['resize']['width'] ?? null;
        $height = $request['transformations']['resize']['height'] ?? null;
        $cropWith = $request['transformations']['crop']['width'] ?? null;
        $cropHeight = $request['transformations']['crop']['height'] ?? null;
        $x = $request['transformations']['crop']['x'] ?? null;
        $y = $request['transformations']['crop']['y'] ?? null;
        $rotate = $request['transformations']['rotate'] ?? null;
        $format = $request['transformations']['format'] ?? $image->format;
        $compress = $request['transformations']['compress'] ?? null;
        //dd($request['transformations']['format']);
        try {
            $filters = array_keys(array_filter(
                $request['transformations']['filters'],
                fn($value) => $value === true
            ));
        } catch (\Exception $e) {
            $filters = null;
        }
        $filter = $filters[0] ?? null;

        if ($with && $height) {
            $img->resize($with, $height);
        }

        if ($x && $y) {
            if ($cropWith && $cropHeight) {                
                $img->crop($cropWith, $cropHeight, $x, $y); //para quitar una parte de la imagen
            } else {
                $img->crop($x, $y);
            }
        }

        if ($rotate) {
            $img->rotate($rotate);
        }

        if ($filter == 'transparent') {
            $img->background('red');
        }

        $imageName = 'mod' . $image->name;
        $this->imageService->deleteByNameAndFile($imageName);
        $img->save(public_path('images/' . $imageName), 100);

        $toEncode = public_path("images/$imageName");
        $manager2 = new ImageManager(new Driver());
        $imgToEncode = $manager2->read($toEncode);

        if ($format) {
            $encoded =  $imgToEncode->encodeByExtension($format, 30);
        }
        if ($compress) {            
            if ($format) {
                $encoded = $imgToEncode->encodeByExtension($format, 50);
            } else {
                $encoded = $imgToEncode->encodeByExtension($image->format, 50);
            }
        }
        $size = round($encoded->size() / 1024 / 1024, 2);
        if ($format) {
            $newName = substr($image->name, 0, -4);
            $imageName = "mod$newName" . "." . "$format";
            $this->imageService->deleteByNameAndFile($imageName);
            $encoded->save(public_path('images/' . $imageName), 100);
        }

        return $this->imageRepository->create([
            'user_id' => $image->user_id,
            'original_image_id' => $image->id,
            'path' => $image->path,
            'width' => $img->width() ?? $image->name,
            'height' => $img->height() ?? $image->height,
            'image_name' => $imageName,
            'x' => $x ?? $image->x,
            'y' => $y ?? $image->y,
            'size' => $size ?? $image->size,
            'format' => $format ?? $image->format,
            'rotate' => $rotate ?? $image->rotate,
            'filter' => false,
        ]);
    }
}
