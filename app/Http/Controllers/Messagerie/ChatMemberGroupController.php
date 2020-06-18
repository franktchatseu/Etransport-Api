<?php

namespace App\Http\Controllers\Messagerie;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\APIError;
use App\Models\Messagerie\ChatMemberGroup;

class ChatMemberGroupController extends Controller
{    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = ChatMemberGroup::simplePaginate($req->has('limit') ? $req->limit : 15);
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
        $data = $req->all();

        $this->validate($data, [
            'status' => 'required',
            'chat_group_id' => 'required:exists:chat_groups,id',
            'user_utype_id' => 'required:exists:user_utypes,id',
        ]);
        
        $member = ChatMemberGroup::where([
            ['chat_group_id', $data['chat_group_id']],
            ['user_utype_id', $data['user_utype_id']],
        ])->get();
        if ( count($member) == 0 ) {
            $member = new ChatMemberGroup();
            $member->status = $data['status'];
            $member->chat_group_id = $data['chat_group_id'];
            $member->user_utype_id = $data['user_utype_id'];
            $member->save();
        }
        return response()->json($member);
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
        $member = ChatMemberGroup::find($id);
        if (!$member) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("MEMBERGROUP_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->all();

        $this->validate($data, [
            'status' => 'required'
        ]);

        if ($data['status'] ?? null) $member->status = $data['status'];

        $member->update();
        return response()->json($member);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Place\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $member = ChatMemberGroup::find($id);
        if (!$member) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CHATMEMBERGROUP_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $member->delete();      
        return response()->json();
    }

    public function find($id)
    {
        $member = ChatMemberGroup::find($id);
        if (!$member) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CHATMEMBERGROUP_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($member);
    }

}
