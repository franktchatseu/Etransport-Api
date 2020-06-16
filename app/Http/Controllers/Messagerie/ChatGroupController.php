<?php

namespace App\Http\Controllers\Messagerie;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\APIError;
use App\Models\Messagerie\ChatGroup;
use App\Models\Messagerie\ChatMemberGroup;
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

        if ($req->file('profile') ?? null) {
            $filePaths = $this->saveSingleImage($this, $req, 'profile', 'groups');
            $data['profile'] = json_encode(['images' => $filePaths]);
        }
        
        if ($data['profile'] ?? null) $group->profile = $data['profile'];
        if (null ?? $data['name']) $group->name = $data['name'];
        
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
}
