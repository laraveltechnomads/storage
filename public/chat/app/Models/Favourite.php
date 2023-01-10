<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FavouriteType;

class Favourite extends Model
{
    use HasFactory;
    protected $table = 'favourites';
    
    protected $fillable = [
    	'user_id',
    	'favourite_type',
        'select_id',
        'chapterId',
        'versionId',
        'bookId',
        'languageId',
        'verseName'
    ];

    public function favourite_type() {
        return $this->hasOne(FavouriteType::class,'favourite_type','favourite_type');
    }

}
