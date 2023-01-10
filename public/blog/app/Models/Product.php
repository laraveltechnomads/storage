<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "products";

    protected $fillable = [
        'cat_id',
        'product_name',
        'product_image',
        'product_slug',
        'product_description',
        'product_status',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    public function category(){
        return $this->belongsTo(Categories::class, 'cat_id', 'id');
    }
}
