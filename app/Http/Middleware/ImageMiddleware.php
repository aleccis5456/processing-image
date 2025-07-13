<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Image;

class ImageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {        
        $imageId = $request->id;
        $image = Image::find($imageId);
        if (!$image) {
            return response()->json(['error' => 'Image not found'], 404);
        }

        if($request->user()->id != $image->user_id){
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
