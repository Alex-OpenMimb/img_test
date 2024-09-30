<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $table = 'tags';

    protected $fillable = [
        'name',
    ];

    //Relationhpis
    public function notes()
    {
        return $this->hasMany( Note::class );
    }

    //Getters
    protected function name(): Attribute
    {
        return Attribute::make(
            set: function ($value){
                return $value ? ucfirst($value) : $value;
            },
        );
    }

}
