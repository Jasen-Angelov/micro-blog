<?php

namespace App\Services;

use App\Models\Image;
use Slim\Http\UploadedFile;

class ImageManager
{
   private static string $directory = DIRECTORY_SEPARATOR .'resources/images' . DIRECTORY_SEPARATOR;

   public static function create_image_from_file(UploadedFile $data): Image
   {
       $path        = self::move_uploaded_file($data);
       $image       = new Image();
       $image->path = $path;
       $image->name = htmlentities($data->getClientFilename());
       $image->save();

       return $image;
   }
   private static function move_uploaded_file( UploadedFile $uploadedFile): string
   {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename  = bin2hex(random_bytes(8));
        $filename  = sprintf('%s.%0.8s', $basename, $extension);
        $uploadedFile->moveTo(APP_ROOT . self::$directory . $filename);

        return self::$directory . $filename;
   }

    public static function delete_existing_images( Image $image): bool
    {

        if (file_exists(APP_ROOT . $image->path)){

            return unlink(APP_ROOT . $image->path);
        }

        return $image->delete();
    }
}