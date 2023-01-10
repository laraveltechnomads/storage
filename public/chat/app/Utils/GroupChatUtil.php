<?php

namespace App\Utils;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\GroupChat;
use DB;
use Illuminate\Support\Facades\File;
use Str;

Class GroupChatUtil
{
    /* Single user group chat create*/
    public function groupChatAdd($request)
    {
        $members = [];
        DB::beginTransaction();
        try
        {
            $group_pic = NULL;
            if ($request->hasFile('group_pic')) {
                $group_pic = uploadFile($request->file('group_pic'), 'chat');
            }
            $user = auth()->user();
            if(isset($request->members_id))
            {
                $members_id = json_decode($request->members_id);
                if(isset($members_id) && count($members_id) > 0) 
                {    
                    $users_id = User::whereIn('id', $members_id)->where([['church_id', '=', $user->church_id], ['u_type', '=', config('constants.u_type.user') ]])->pluck('id');
                    if(isset($users_id))
                    {
                        $u_id = NULL;
                        foreach ($users_id as $key => $mem_id) {
                            if(($user->id != $mem_id) && !$u_id)
                            {
                                $u_id = $user->id;
                                $m_id = $u_id; 
                                $uArr = strval($m_id);
                                array_push($members, $uArr);
                            }
                            $userArr = strval($mem_id);
                            array_push($members, $userArr);
                            
                        }
                        $members = json_encode($members);
                    }
                }
            }

            $alrGroup = GroupChat::where('user_id', $user->id)->where('group_name', Str::ucfirst($request->group_name))->first();
            if($alrGroup)
            {
                return response([
                    'success' => false,
                    'message' => $request->group_name. ' Name Already created.',
                    'data' => Config('constants.emptyData'),
                ], config('constants.invalidResponse.statusCode'));
            }
            
            $groupChat = GroupChat::create([
                'user_id' => $user->id,
                'group_id' => strtotime("now"),
                'members_id' => $members,
                'group_pic' => $group_pic,
                'group_name' => Str::ucfirst($request->group_name)
            ]);
            
            DB::commit();

            $response = [
                'group_chat_id' => $groupChat->id,
                'group_id' => $groupChat->group_id,
                'create_user_id' => $groupChat->user_id,
                'group_pic' => $groupChat->group_pic,
                'group_name' => Str::ucfirst($groupChat->group_name)
            ];
            
            return response([
                'success' => true,
                'message' => 'Group created.',
                'data' => $response,
            ], config('constants.validResponse.statusCode'));
           
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'data'    => config('constants.emptyData'),
            ], config('constants.invalidResponse.statusCode'));
        }  
    }

    /*single user all groups chat List   */
    public function groupChatList()
    {
        $response = [];
        $groups_id = [];
        DB::beginTransaction();
        try
        {
            $user = auth()->user();
            $groupChats = GroupChat::get();
            if(isset($groupChats))
            {
                $groups_id = $this->memberGroupChats($groupChats, $user, $groups_id);
                $memberGroupChatsList = GroupChat::whereIn('id', $groups_id)->get();
                if(isset($memberGroupChatsList))
                {
                    foreach ($memberGroupChatsList as $key => $mGroup) {
                        $existImage = store_group_pic_path(). $mGroup->group_pic;
                        if (File::exists($existImage)) {
                            $mGroup->group_pic = group_pic_path().$mGroup->group_pic;
                        }

                       $groupArr = [
                            'group_chat_id' => $mGroup->id,
                            'group_id' => $mGroup->group_id,
                            'create_user_id' => $mGroup->user_id,
                            'group_pic' => $mGroup->group_pic,
                            'group_name' => Str::ucfirst($mGroup->group_name)
                        ];
                        array_push($response, $groupArr);
                    }
                }
            }
            DB::commit();
            return response([
                'success' => true,
                'message' => 'Groups Chat List.',
                'data' => $response,
            ], config('constants.validResponse.statusCode'));
           
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'data'    => config('constants.emptyData'),
            ], config('constants.invalidResponse.statusCode'));
        }  
    } 

    /* single user group chat members list  */
    public function groupChatMembersList($group_id)
    {
        $response = [];
        $members = [];
        DB::beginTransaction();
        try
        {
            $user = auth()->user();
            $group = GroupChat::where('group_id', $group_id)->first();
            if($group)
            {
                $existImage = store_group_pic_path(). $group->group_pic;
                if (File::exists($existImage)) {
                    $group->group_pic = group_pic_path().$group->group_pic;
                }
                
                $members_id = json_decode($group->members_id);
                $memberCheck = User::whereIn('id', $members_id)->where([['church_id', '=', $user->church_id],['u_type', '=', config('constants.u_type.user') ]])->first();
                if($memberCheck == NULL)
                {
                    return dataNotFound();
                } 
                foreach ($members_id as $key => $mem_id) {
                    
                    $member = User::where([['church_id', '=', $user->church_id],['id' ,'=', $mem_id], ['u_type', '=', config('constants.u_type.user') ]])->first();
                    if(isset($member) )
                    {
                        $existImage = store_pic_path(). $member->pic;
                        if (File::exists($existImage)) {
                            $member->pic = profile_pic_path().$member->pic;
                        }
                        
                        $userArr = [
                            'user_id' =>  $member->id,
                            'name' =>  $member->name,
                            'first_name' =>  $member->first_name,
                            'last_name' =>  $member->last_name,
                            'email' =>  $member->email,
                            'pic' => $member->pic,
                            'uniqid' => $member->uniqid
                        ];
                        array_push($members, $userArr);
                    }
                }

                $groupArr = [
                    'group_chat_id' => $group->id,
                    'group_id' => $group->group_id,
                    'create_user_id' => $group->user_id,
                    'group_pic' => $group->group_pic,
                    'group_name' => Str::ucfirst($group->group_name),
                    'members' => $members
                ];
                array_push($response, $groupArr);
                
                DB::commit();
                return response([
                    'success' => true,
                    'message' => 'Group Chat Memebers List.',
                    'data' => $response,
                ], config('constants.validResponse.statusCode'));
            }
            return dataNotFound();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'data'    => config('constants.emptyData'),
            ], config('constants.invalidResponse.statusCode'));
        }  
    } 

    /* single user selected group list remove */
    public function groupChatListRemove($group_id)
    {
        DB::beginTransaction();
        try
        {
            $user = auth()->user();
            $group = GroupChat::where('user_id', $user->id)->where('group_id', $group_id)->first();
            if($group)
            {
                removeFile($group->group_pic, 'chat');
                $group->delete();
            }
                       
            DB::commit();
            
            return response([
                'success' => true,
                'message' => 'Group deleted.',
                'data' => config('constants.emptyData'),
            ], config('constants.validResponse.statusCode'));
           
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'data'    => config('constants.emptyData'),
            ], config('constants.invalidResponse.statusCode'));
        }  
    }

    /* Update Group Chat*/
    public function updateGroupChat($request)
    {
        DB::beginTransaction();
        try
        {
            $user = auth()->user();
            $group = GroupChat::where('user_id', $user->id)->where('group_id', $request->group_id)->first();
            if($group)
            {   
                if($request->group_name){
                    $group->group_name = Str::ucfirst($request->group_name);
                }
                $group_pic = $group->group_pic;             
                if ($request->hasFile('group_pic')) {
                    $group_pic = uploadFile($request->file('group_pic'), 'chat');
                    removeFile($group->group_pic, 'chat');
                    $group->group_pic = $group_pic;
                }
                $group->update();
                DB::commit();
                return response([
                    'success' => true,
                    'message' => 'Group updated.',
                    'data' => config('constants.emptyData'),
                ], config('constants.validResponse.statusCode'));
            }
            return dataNotFound();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'data'    => config('constants.emptyData'),
            ], config('constants.invalidResponse.statusCode'));
        }  
    }

    /*  Members Add Group Chat   */
    public function membersAddGroupChat($request)
    {
        $response = [];
        $members = [];
        DB::beginTransaction();
        try
        {
            $user = auth()->user();
            $group = GroupChat::where('user_id', $user->id)->where('group_id', $request->group_id)->first();
            if($group)
            {
                if(isset($request->members_id))
                {
                    $members_id = json_decode($request->members_id);
                    if(isset($members_id) && count($members_id) > 0) 
                    {    
                        $group->members_id =  array_merge (json_decode($group->members_id), $members_id);
                        $users_id = User::whereIn('id', $group->members_id)->where([['church_id', '=', $user->church_id], ['u_type', '=', config('constants.u_type.user') ]])->pluck('id');
                        if(isset($users_id))
                        {
                            foreach ($users_id as $key => $mem_id) {
                                $userArr = strval($mem_id);
                                array_push($members, $userArr);
                            }
                            $group->members_id = json_encode($members);
                        }
                    }
                }
                $group->update();
                DB::commit();
                return response([
                    'success' => true,
                    'message' => 'Group New Members updated.',
                    'data' => config('constants.emptyData'),
                ], config('constants.validResponse.statusCode'));
            }
            return dataNotFound();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'data'    => config('constants.emptyData'),
            ], config('constants.invalidResponse.statusCode'));
        }  
    }

    /* Members Exit to Group Chat*/
    public function membersExitGroupChat($request)
    {
        $response = [];
        $members = [];
        DB::beginTransaction();
        try
        {
            $user = auth()->user();
            $group = GroupChat::where('user_id', $user->id)->where('group_id', $request->group_id)->first();
            if($group)
            {
                if(isset($request->members_id))
                {
                    $members_id = json_decode($request->members_id);
                    if(isset($members_id) && count($members_id) > 0) 
                    {    
                        $group->members_id =  array_merge (json_decode($group->members_id), $members_id);
                        $users_id = User::whereIn('id', $group->members_id)->whereNotIn('id', $members_id)->where([['church_id', '=', $user->church_id], ['u_type', '=', config('constants.u_type.user') ]])->pluck('id');
                        if(isset($users_id))
                        {
                            $u_id = NULL;
                            foreach ($users_id as $key => $mem_id) {
                                if(($user->id != $mem_id) && !$u_id)
                                {
                                    $u_id = $user->id;
                                    $m_id = $u_id; 
                                    $uArr = strval($m_id);
                                    array_push($members, $uArr);
                                }
                                $userArr = strval($mem_id);
                                array_push($members, $userArr);
                            }
                            $group->members_id = json_encode($members);
                        }
                    }
                }
                $group->update();
                DB::commit();
                return response([
                    'success' => true,
                    'message' => 'Group Chat members exited.',
                    'data' => config('constants.emptyData'),
                ], config('constants.validResponse.statusCode'));
            }
            return dataNotFound();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'data'    => config('constants.emptyData'),
            ], config('constants.invalidResponse.statusCode'));
        }  
    }

    /* user group chat list*/
    public function memberGroupChats($groupChats, $user, $groups_id)
    {
        foreach ($groupChats as $key => $group) {
            $group->members_id =  json_decode($group->members_id);
            $users_id = User::whereIn('id', $group->members_id)->where([['church_id', '=', $user->church_id], ['u_type', '=', config('constants.u_type.user') ]])->pluck('id');
            if(isset($users_id))
            {   
                foreach ($users_id as $key => $mem_id) {
                    if($user->id == $mem_id)
                    {
                       $grArr = strval($group->id);
                        array_push($groups_id, $grArr);
                    }
                }			
            }
        }
        return $groups_id;
    } 

    /* Login Member Exit Group */
    public function loginMemberExitGroup($request)
    {
        $response = [];
        $members = [];
        DB::beginTransaction();
        try
        {
            $user = auth()->user();
            $group = GroupChat::where('group_id', $request->group_id)->first();
            if($group)
            {
                if($group->user_id == $user->id)
                {
                    return response()->json([
                        'message' => 'You are the only admin in this group chat. Please make someone else admin.',
                        'data'    => config('constants.emptyData'),
                    ], config('constants.invalidResponse.statusCode'));
                }
                
                $group->members_id = json_decode($group->members_id);
                $users_id = User::whereIn('id', $group->members_id)->whereNotIn('id', [$user->id])->where([['church_id', '=', $user->church_id], ['u_type', '=', config('constants.u_type.user') ]])->pluck('id');
                if(isset($users_id))
                {
                    $u_id = NULL;
                    foreach ($users_id as $key => $mem_id) {
                            $userArr = strval($mem_id);
                            array_push($members, $userArr);
                    }
                    $group->members_id = json_encode($members);
                    $group->update();
                    DB::commit();
                }
                return response([
                    'success' => true,
                    'message' => 'You are exited Group..',
                    'data' => config('constants.emptyData'),
                ], config('constants.validResponse.statusCode'));
            }
            return dataNotFound();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'data'    => config('constants.emptyData'),
            ], config('constants.invalidResponse.statusCode'));
        }  
    }


    /* Admin created other member admin*/
    public function adminAddGroup($request)
    {
        $response = [];
        $groups_id = [];
        DB::beginTransaction();
        try
        {
            $user = auth()->user();
            $group = GroupChat::where('user_id', $user->id)->where('group_id', $request->group_id)->first();
            if(isset($group))
            {
                $group->members_id =  json_decode($group->members_id);
                $users_id = User::whereIn('id', $group->members_id)->where([['church_id', '=', $user->church_id], ['u_type', '=', config('constants.u_type.user') ]])->pluck('id');
                if(isset($users_id))
                {   
                    foreach ($users_id as $key => $mem_id) {
                        $grArr = strval($mem_id);
                        array_push($groups_id, $grArr);
                        if($request->member_id == $mem_id)
                        {
                            $group->user_id = $mem_id;
                        }
                        
                    }		
                    $group->members_id = json_encode($groups_id);	
                }
                $group->update();
                
                DB::commit();
                return response([
                    'success' => true,
                    'message' => 'Groups Chat List.',
                    'data' => config('constants.emptyData'),
                ], config('constants.validResponse.statusCode'));
            }
            return dataNotFound();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'data'    => config('constants.emptyData'),
            ], config('constants.invalidResponse.statusCode'));
        }  
    }

}