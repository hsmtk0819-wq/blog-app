<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'published_on', 'body'])]
class Article extends Model
{
    protected function casts(): array
    {
        return [
            'published_on' => 'date',
        ];
    }
}