<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Services\TransformService;
use App\Repositories\ImageRepository;
use App\Models\Image;

class ProcessImage implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $imageId, 
        public array $requestData,        
    ){                  
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {        
        $image = Image::find($this->imageId);
        if(!$image){
            throw new \Exception('Image not found');
        }

        $transformService =  app(TransformService::class);
        $transformService->transform($image,  $this->requestData);             
    }
}
