<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favourite;
use App\Models\FavouriteType;
use App\Utils\FavouriteUtil;

class FavouriteController extends Controller
{
    protected $favouriteUtil;

    public function __construct(FavouriteUtil $favouriteUtil)
    {
        $this->favouriteUtil = $favouriteUtil;
    }

    // favourite select item  Add or Remove
    public function favouriteAddRemove(Request $request, $type_name, $select_id)
    {
        return $this->favouriteUtil->favouriteAddRemove($request, $type_name, $select_id);
    }

    // favourite select item  Add or Remove
    public function favouritePostAddRemove(Request $request, $type_name, $select_id = NULL)
    {
        return $this->favouriteUtil->favouriteAddRemove($request, $type_name, $select_id);
    }

    /*  all favourite list */
    public function index(Request $request, $type_name)
    {
        return $this->favouriteUtil->favouriteList($request, $type_name);
    }

    /* all Favourites List*/
    public function allFavouritesList(Request $request)
    {
        return $this->favouriteUtil->allFavouritesList($request);
    }
} 
