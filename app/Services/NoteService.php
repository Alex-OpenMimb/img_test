<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NoteService
{
     public static function storeImage( $note,$image )
    {
        $path     = 'image/note';
        $title    = Str::slug( $note->title,'-' );
        $nameFile = $title.'.png';

        Storage::disk('public')->putFileAs( $path, $image, $nameFile );

        return $path .'/'. $nameFile;
    }
}
