<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    protected $fillable = [
        'user_id',
        'original_image_id',
        'path',
        'name',
        'width',
        'height',
        'x',
        'y',
        'rotate',
        'format',
        'filter',   
        'size',     
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}            