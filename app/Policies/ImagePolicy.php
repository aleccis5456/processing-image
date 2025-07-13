<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Image;

class ImagePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, Image $image){
        return $user->id === $image->user_id;
    }
}
