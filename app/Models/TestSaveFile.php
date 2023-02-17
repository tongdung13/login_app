<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TestSaveFile extends Model
{
    use HasFactory;

    protected $table = 'test_save_files';

    protected $fillable = [
        'test',
        'file_name',
    ];

    public function getFileNameAttribute($image)
    {
        if (!empty($image)) {
            return  Storage::disk('s3')->temporaryUrl($image, now()->addMinutes(30));
        }
        return null;
    }
}
