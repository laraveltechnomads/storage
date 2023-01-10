<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GroupChat;
use App\Utils\GroupChatUtil; 

class ChatController extends Controller
{
    protected $groupChatUtil;

    public function __construct(GroupChatUtil $groupChatUtil)
    {
        $this->groupChatUtil = $groupChatUtil;
    }

    /* Group Chat List */
    public function groupChatList(Request $request)
    {
        return $this->groupChatUtil->groupChatList($request);
    }

    /* Group Chat Create */
    public function groupChatAdd(Request $request)
    {
        return $this->groupChatUtil->groupChatAdd($request);
    }

    /* group chat members list */
    public function groupChatMembersList($group_id)
    {
        return $this->groupChatUtil->groupChatMembersList($group_id);
    }

    /* single user selected group list remove */
    public function groupChatListRemove($group_id)
    {
        return $this->groupChatUtil->groupChatListRemove($group_id);
    }

    /* Update Group Chat*/
    public function updateGroupChat(Request $request)
    {
        return $this->groupChatUtil->updateGroupChat($request);
    }

    /*  Members Add Group Chat   */
    public function membersAddGroupChat(Request $request)
    {
        return $this->groupChatUtil->membersAddGroupChat($request);
    }

    /* Members Exit to Group Chat*/
    public function membersExitGroupChat(Request $request)
    {
        return $this->groupChatUtil->membersExitGroupChat($request);
    }

    /* Login Member Exit Group*/
    public function loginMemberExitGroup(Request $request)
    {
        return $this->groupChatUtil->loginMemberExitGroup($request);
    }    

    /* Admin created other member admin*/
    public function adminAddGroup(Request $request)
    {
        return $this->groupChatUtil->adminAddGroup($request);
    }
}