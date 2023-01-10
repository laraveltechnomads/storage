<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Favourite;

class FavouriteType extends Model
{
    use HasFactory;

    protected $table = 'favourite_types';
    
    protected $fillable = [
    	'favourite_type',
    	'favourite_name',
        'favourite_description'
    ];

    public function Favourite() {
        return $this->hasOne(Favourite::class,'favourite_type','favourite_type');
    }
}
