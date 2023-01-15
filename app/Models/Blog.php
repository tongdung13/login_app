<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';
    protected $fillable = [
        'title',
        'content',
        'image',
    ];

    public function getImageAttribute($image)
    {
        if (!empty($image)) {
            return Storage::disk('s3')->temporaryUrl($image, now()->addMinutes(30));
        }
        return null;
    }
}
