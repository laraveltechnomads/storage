<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Post extends Pivot
{
    use HasFactory;
    protected $fillable = [
        "title",
        "description"
    ];
}
