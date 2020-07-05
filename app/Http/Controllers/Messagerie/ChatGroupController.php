<?php

namespace App\Http\Controllers\Messagerie;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\APIError;
use App\Models\Messagerie\ChatGroup;
use App\Models\Messagerie\ChatMemberGroup;
use App\Models\Messagerie\ChatMessageGroup;
use App\Models\Person\UserUtype;
use App\Models\Person\User;

class ChatGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = ChatGroup::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $data = $req->except('profile');

        $this->validate($data, [
            'name' => 'required',
            'reference' => 'required:numeric',
        ]);

        if ( $req->file('profile') ?? null) {
            $filePaths = $this->saveSingleImage($this, $req, 'profile', 'groups');
            $data['profile'] = json_encode(['images' => $filePaths]);
        }

        $group = new ChatGroup();
        $group->name = $data['name'];
        $group->profile = $data['profile'] ?? null;
        $group->code_source = $data['code_source'] ?? null;
        $group->reference = $data['reference'] ?? null;
        $group->save();
       
        return response()->json($group);
    }

    public function createGroupPriest(Request $req , $id)
    {   

        $user_utype = UserUtype::find($id);
        if (!$user_utype) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("USER_UTYPE_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->except('profile');

        $this->validate($data, [
            'name' => 'required',
        ]);

        if ( $req->file('profile') ?? null) {
            $filePaths = $this->saveSingleImage($this, $req, 'profile', 'groups');
            $data['profile'] = json_encode(['images' => $filePaths]);
        }

        $group = new ChatGroup();
        $group->name = $data['name'];
        $group->profile = $data['profile'] ?? null;
        $group->code_source = 'PRIEST_RESPONSE_US';
        $group->reference = $id;
        $group->save();
       
        return response()->json($group);
    }

    // public function createMemberWithGroup(Request $req)
    // {
    //     $data = $req->except('profile_group');

    //     $this->validate($data, [
    //         'name_group' => 'required',
    //         'creator_id' => 'required',
    //         'user_utype_id' => 'required:exists:user_utypes,id',
    //     ]);

    //     if ( $req->file('profile_group') ?? null) {
    //         $filePaths = $this->saveSingleImage($this, $req, 'profile_group', 'groups');
    //         $data['profile_group'] = json_encode(['images' => $filePaths]);
    //     }

    //     $group = new ChatGroup();
    //     $group->name = $data['name_group'];
    //     $group->profile = $data['profile_group'] ?? null;
    //     $group->code_source = 'PRIEST_RESPONSE_US' ?? null;
    //     $group->reference = $data['creator_id'] ?? null;
    //     $group->save();
       
    //     $param= $group;
    //     // return response()->json($group);

    //     $chatGroup = ChatGroup::orderBy('id', 'DESC')->first();
    //     $member = ChatMemberGroup::where([
    //         ['chat_group_id', $chatGroup->id ],
    //         ['user_utype_id', $data['user_utype_id']],
    //     ])->get();
    //     if ( count($member) == 0 ) {
    //         $member = new ChatMemberGroup();
    //         $member->status = 'ACCEPTED';
    //         $member->chat_group_id = $chatGroup->id;
    //         $member->user_utype_id = $data['user_utype_id'];
    //         $member->save();
    //         $param->member1= $member;
    //     }
    //     $member2 = ChatMemberGroup::where([
    //         ['chat_group_id', $chatGroup->id ],
    //         ['user_utype_id', $data['creator_id']],
    //     ])->get();
    //     if ( count($member2) == 0 ) {
    //         $member2 = new ChatMemberGroup();
    //         $member2->status = 'ACCEPTED';
    //         $member2->chat_group_id = $chatGroup->id;
    //         $member2->user_utype_id = $data['creator_id'];
    //         $member2->save();
    //         $param->creator= $member2;
    //     }
        


    //     return response()->json($param);
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Place\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $group = ChatGroup::find($id);
        if (!$group) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CHATGROUP_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->except('profile');

        $this->validate($data, [
            'name' => 'required'
        ]);

        if ($file = $req->file('profile')) {
            $filePaths = $this->saveSingleImage($this, $req, 'profile', 'groups');
            $data['profil'] = json_encode(['images' => $filePaths]);
        }
        
        if (isset($data['profil'])) $group->profile = $data['profil'];
        if (isset($data['name'])) $group->name = $data['name'];
        
        $group->update();
        return response()->json($group);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Place\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = ChatGroup::find($id);
        if (!$group) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CHATGROUP_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $group->delete();      
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = ChatGroup::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        $group = ChatGroup::find($id);
        if (!$group) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CHATGROUP_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($group);
    }

    public function findUsersGroup(Request $request, $id) {
        $group = ChatGroup::find($id);
        if (!$group) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CHATGROUP_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $users = ChatMemberGroup::orderBy('id', 'DESC')
        ->whereChatGroupId($id)
        ->join('user_utypes', 'user_utypes.id', '=', 'chat_member_groups.user_utype_id')
        ->join('users', 'users.id', '=', 'user_utypes.user_id')
        ->select('users.*', 'chat_member_groups.status', 'chat_member_groups.id as id_member')
        ->simplePaginate($request->has('limit') ? $request->limit : 15);
        return response()->json($users);
    }

    public function findMessagesGroup(Request $request, $id) {
        $group = ChatGroup::find($id);
        if (!$group) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CHATGROUP_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $users = ChatMessageGroup::orderBy('id', 'DESC')
        ->whereChatGroupId($id)
        ->join('user_utypes', 'user_utypes.id', '=', 'chat_message_groups.sender_id')
        ->join('users', 'users.id', '=', 'user_utypes.user_id')
        ->select('chat_message_groups.*', 'chat_member_groups.id as id_member')
        ->simplePaginate($request->has('limit') ? $request->limit : 15);
        return response()->json($users);
    }

    // public function findForumGroup(Request $request) {
       
    //     $forums = ChatGroup::orderBy('id', 'DESC')
    //     ->whereCodeSource('FORUM')
    //     ->select('chat_groups.*')
    //     ->simplePaginate($request->has('limit') ? $request->limit : 15);
    //     return response()->json($forums);
    // }

    

    public function findMessages(Request $request, $id) {
        $group = ChatGroup::find($id);
        if (!$group) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CHATGROUP_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $users = ChatMemberGroup::orderBy('id', 'DESC')
        ->whereChatGroupId($id)
        ->join('chat_message_groups', 'chat_member_groups.id', '=', 'chat_message_groups.sender_id')
        ->select('chat_member_groups.id as id_member', 'chat_message_groups.*')
        ->simplePaginate($request->has('limit') ? $request->limit : 15);
        return response()->json($users);
    }

    // public function findMessagesPriest(Request $request, $id) {
    //     $group = ChatGroup::find($id);
    //     if (!$group) {
    //         $apiError = new APIError;
    //         $apiError->setStatus("404");
    //         $apiError->setCode("CHATGROUP_NOT_FOUND");
    //         return response()->json($apiError, 404);
    //     }
    //     $code_source = 'PRIEST_RESPONSE_US';
    //     $users = ChatGroup::orderBy('id', 'DESC')
    //     ->whereCodeSource($code_source)
    //     ->join('chat_message_groups', 'chat_groups.id', '=', 'chat_message_groups.group_id')
    //     ->select( 'chat_message_groups.*')
    //     ->simplePaginate($request->has('limit') ? $request->limit : 30);
    //     return response()->json($users);
    // }

    // public function findMessagesForResponsePriestUs(Request $request, $id) {
    //     $user = User::find($id);
    //     if (!$user) {
    //         $apiError = new APIError;
    //         $apiError->setStatus("404");
    //         $apiError->setCode("CHATGROUP_NOT_FOUND");
    //         return response()->json($apiError, 404);
    //     }

    //     // $users = ChatMemberGroup::orderBy('id', 'DESC')
    //     // ->whereChatGroupId($id)
    //     // ->join('chat_message_groups', 'chat_member_groups.id', '=', 'chat_message_groups.sender_id')
    //     // ->join('chat_groups', 'chat_groups.id', '=', 'chat_message_groups.sender_id')
    //     // ->select('chat_member_groups.id as id_member', 'chat_message_groups.*')   
    //     // ->simplePaginate($request->has('limit') ? $request->limit : 15);
    //     // return response()->json($users);

    //     $users = ChatMessageGroup::select('chat_member_groups.id as id_member', 'chat_message_groups.*')
    //     ->join('chat_member_groups', 'chat_member_groups.id', '=', 'chat_message_groups.sender_id')
    //     ->join('chat_groups', 'chat_groups.id', '=', 'chat_message_groups.group_id')
    //     ->where(['chat_groups.code_source' => "PRIEST_RESPONSE_US"])
    //     ->simplePaginate($request->has('limit') ? $request->limit : 15);
    // return response()->json($users);
    // }

    public function findGroupsForUSer(Request $request, $id) {
        $user = User::find($id);
        if (!$user) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("USER_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $users = ChatMemberGroup::orderBy('id', 'DESC')
        ->whereUserUtypeId($id)
        // ->whereStatus('ACCEPTED')
        ->join('chat_groups', 'chat_groups.id', '=', 'chat_member_groups.chat_group_id')
        ->select('chat_groups.*', 'chat_member_groups.id as id_sender', 'chat_member_groups.status as status')
        ->simplePaginate($request->has('limit') ? $request->limit : 15);
        return response()->json($users);
    }

    public function findGroupOfPriest(Request $request, $id) {
        $user_utype = User::find($id);
        if (!$user_utype) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("USER_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $groups = ChatGroup::orderBy('id', 'DESC')
        ->whereCodeSource('PRIEST_RESPONSE_US')
        ->whereReference($id)->first();
        // ->select('chat_groups.*')
        // ->simplePaginate($request->has('limit') ? $request->limit : 1);
        return response()->json($groups);
    }
}
