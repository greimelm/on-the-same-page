<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // title, author, isbn, published_year, description, cover_image
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'author',
        'isbn',
        'open_library_id',
        'cover_image',
        'publish_date',
        'publisher',
        'number_of_pages',
        'subjects',
    ];

    protected $casts = [
        'subjects' => 'array',
    ];
}
