<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function __construct() {
    }

    public function saveImage(UploadedFile $file, string $folder = ''): string
    {
        $name = md5(now() . '_' . $file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
        $filePath = Storage::disk('public')->putFileAs($folder ? "/$folder" : "/images", $file, $name);

        return $filePath;
    }

}
