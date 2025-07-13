<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ImageRepository;
use App\Services\ImageService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class ImageController extends Controller
{
    public function __construct(
        protected ImageRepository $imageRepository,
        protected ImageService $imageService,
    ){}

    public function show(int $id){  
        $image = $this->imageService->show($id);
        Gate::authorize('view', $image);
        return response()->json([
            'image' => $image,
        ]);        
    }

    public function upload(Request $request){
        $validador = Validator::make($request->all(), [
            'image' => 'required|image'
        ]);
        if($validador->fails()){
            return response()->json(['error' => $validador->errors()], 400);
        }
                 
        try{
            $data = $this->imageService->processAndSave($request->file('image'));
            $img = $this->imageRepository->create($data);
            return response()->json([
                'message' => 'Image uploaded successfully',                
                'image' => $img,
            ], 200);
        }catch(\Exception $e){
            throw new \Exception($e->getMessage());            
        }
    }

    public function info($image_name){
        $this->imageService->deleteByNameAndFile($image_name);
    }
}
