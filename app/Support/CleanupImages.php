<?php

namespace App\Support;

use Illuminate\Support\Facades\File;

class CleanupImages
{
    public static function cleanup(){
        $dir = public_path('images');
        
        if(File::exists($dir)){
            File::deleteDirectory($dir);
        }
    }
}
