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
            $fileName = time() . '-' . $uploadedFile->getClientOriginalName();
        }

        $filePath = $uploadedFile->storeAs($folder, $fileName, $disk);

        $filePath = self::getFileUrl($filePath, $disk);
        
        return $filePath;
    }

    public static function uploadMany(array $files, string $folder, string $disk = null): array
    {
        $paths = [];

        foreach($files as $file){
            $paths[] = self::uploadFile($file, $folder, null, $disk);
        }

        return $paths;
    }

    private static function getFileUrl(string $filePath, $disk = null): string
    {   
        $url = Storage::url($filePath);
    
        if($disk !== 's3') $url = url($url);
        
        return $url;
    }
}