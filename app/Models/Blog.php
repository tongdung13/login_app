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
            return  Storage::disk('s3')->temporaryUrl($image, now()->addMinutes(30));
        }
        return null;
    }

    public function encode_img_base64($img_path = false): string
    {
        $image = '';
        if ($img_path) {
            $path = $img_path;
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $image = 'data:image/' . $type . ';base64,' . base64_encode($data);
            return $image;
        }
        return $image;
    }
}
