<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "author",
        "slug",
        "meta_title",
        "meta_description",
        'meta_keywords',
        "title",
        "sub_title",
        "tag_id",
        "category",
        "sub_category",
        "description",
        "feature_image",
        "like",
        "dislike",
        "status",
        'publish_date'
    ];

    protected $casts = [
        'tag_id' => 'array',
    ];
    
}
