<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


class FileHandler
{
    public static function generateUserSpecificPath(int|string $userId, string $filePath): string
    {
        return str_replace('@userId', "user-{$userId}", $filePath);
    }

    public static function uploadFile(UploadedFile $uploadedFile, string $folder, string $fileName = null, string $disk = null): string
    {
        if($disk == null){
            $disk = config('filesystems.default');
        }

        if($fileName == null){
            $fileName = time() . '.' . $uploadedFile->getClientOriginalName();
        }

        $filePath = $uploadedFile->storeAs($folder, $fileName, $disk);

        return $filePath;
    }

    public static function getFileUrl(string $filePath): string
    {   
        $url = Storage::url($filePath);
        
        return $url;
    }
}