<?php

namespace App\Http\Controllers\API\V1\Masters;

use App\Http\Controllers\Controller;
use App\Models\API\V1\Master\MenuMaster;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function rolefeatures(){
        $roles = [];
        $menu_lists = MenuMaster::distinct('title')->where('active',1)->get(['title']);
        foreach($menu_lists as $menu_list){
            $sub_menus = MenuMaster::where(['title'=>$menu_list->title,'active' => 1])->get(['path','sub_title','title','id']);
            foreach($sub_menus as $sub_menu){
                $roles[$menu_list->title][] = $sub_menu->sub_title;
                if($sub_menu->path != null){
                    $sub_features = json_decode($sub_menu->path,true);
                    foreach($sub_features as $sub_feature){
                        $roles[$menu_list->title][$sub_menu->sub_title][] = $sub_feature;
                        // echo $sub_feature;
                    }
                }
            }
        }
        return $roles;
    }
}
