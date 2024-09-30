<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $table = 'notes';

    protected $fillable = [
        'title',
        'description',
        'image',
        'creation_date',
        'expiration_date',
        'user_id',
        'tag_id',
            ];
}
