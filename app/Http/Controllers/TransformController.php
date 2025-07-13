<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Repositories\TransformRepository;
use App\Services\TransformService;
use Illuminate\Support\Facades\Gate;
use App\Jobs\ProcessImage;


class TransformController extends Controller
{
    public function __construct(
        protected TransformRepository $transformRepository,
        protected TransformService $transformService
    ){}
    
    public function store(Request $request, int $id){
        $image = Image::find($id);
        Gate::authorize('view', $image);
        if (!$image) {
            return response()->json(['error' => 'Image not found'], 404);
        }
        try{                        
            $res = ProcessImage::dispatch($id, $request->all());
            return response()->json([
                'success' => 'Image transformed successfully',                
            ], 200);
        }catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
}
