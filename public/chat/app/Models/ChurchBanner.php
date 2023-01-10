<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Church;

class ChurchBanner extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'church_banners';
    
    protected $fillable = [
    	'banner_image',
    	'church_id',
        'serial_number',
        'is_active'
    ];

    //church events
    public function church()
    {
        return $this->hasOne(Church::class, 'id', 'church_id');
    }
}
