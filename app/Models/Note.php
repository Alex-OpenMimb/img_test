<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'tag_id',];


    //Relationships

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tag()
    {
        return $this->belongsTo( Tag::class );
    }
    protected function title(): Attribute
    {
        return Attribute::make(
            set: function ($value){
                return $value ? ucfirst($value) : $value;
            },
        );
    }

    protected function description(): Attribute
    {
        return Attribute::make(
            set: function ($value){
                return $value ? ucfirst($value) : $value;
            },
        );
    }
}
