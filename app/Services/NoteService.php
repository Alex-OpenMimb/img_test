<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NoteService
{
     public static function storeImage( $note,$image )
    {
        $path     = 'image/note';
        $nameFile = $note->id.'.png';

        Storage::disk('public')->putFileAs( $path, $image, $nameFile );

        return $path .'/'. $nameFile;
    }

}
