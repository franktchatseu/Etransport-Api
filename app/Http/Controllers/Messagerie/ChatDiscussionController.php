<?php

namespace App\Http\Controllers\Messagerie;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\APIError;
use App\Models\Messagerie\ChatMemberGroup;
use App\Models\Messagerie\ChatDiscussion;
use App\Models\Messagerie\ChatMessageDuo;
use App\Models\Person\User;
use App\Models\Person\UserUtype;

class ChatDiscussionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = ChatDiscussion::simplePaginate($req->has('limit') ? $req->limit : 15);
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
            'user_utype1_id' => 'required:exists:user_utypes,id',
            'user_utype2_id' => 'required:exists:user_utypes,id',
        ]);

        $discussion = ChatDiscussion::where([
            ['user_utype1_id', $data['user_utype1_id']],
            ['user_utype2_id', $data['user_utype2_id']],
        ])->get();

        if (count($discussion) == 0) {
            $discussion = new ChatDiscussion();
            $discussion->user_utype1_id = $data['user_utype1_id'];
            $discussion->user_utype2_id = $data['user_utype2_id'];
            $discussion->save();
        }
        return response()->json($discussion);
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
        $discussion = ChatDiscussion::find($id);
        if (!$discussion) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CHATDISCUSSION_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->all();

        // en cours 
        $discussion->update();
        return response()->json($discussion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Place\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $discussion = ChatDiscussion::find($id);
        if (!$discussion) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CHATDISCUSSION_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $discussion->delete();      
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = ChatDiscussion::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        $discussion = ChatDiscussion::find($id);
        if (!$discussion) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CHATGROUP_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($discussion);
    }

    public function findCorrespondants(Request $request, $id) {
        $user = UserUtype::find($id);
        if (!$user) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("USERUTYPE_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        $results = [];
        $users = ChatDiscussion::
        // orderBy('chat_discussions.id', 'DESC')
        where('user_utype1_id', '=', $id)
        ->orWhere('user_utype2_id', '=', $id)
        ->join('user_utypes as user_utypes1', 'user_utypes1.id', '=' ,'chat_discussions.user_utype1_id')
        ->join('user_utypes as user_utypes2', 'user_utypes2.id', '=' ,'chat_discussions.user_utype2_id')
        ->join('users as users1', 'users1.id', '=', 'user_utypes1.user_id')
        ->join('users as users2', 'users2.id', '=', 'user_utypes2.user_id')
        ->select('chat_discussions.id as chat_discussion_id', 'users2.*')
        ->distinct()
        ->get();

        return response()->json($users);
    }

    public function findMessages(Request $request, $id) {
        $discussion = ChatDiscussion::find($id);
        if (!$discussion) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CHATDISCUSSION_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $messages = ChatMessageDuo::orderBy('id', 'ASC')
        ->whereChatDiscussionId($id)
        ->select('chat_message_duos.*')
        ->simplePaginate($request->has('limit') ? $request->limit : 15);
        return response()->json($messages);
    }

    public function findMessages2(Request $request, $id_priest, $id_user) {
        $user = User::find($id_priest);
        if (!$user) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CHATDISCUSSION_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $discutionID = ChatDiscussion::
        where('user_utype1_id', '=', $id_priest)
        ->orwhere('user_utype2_id', '=', $id_user);

        return $discutionID;

        $messages = ChatMessageDuo::orderBy('id', 'ASC')
        ->whereChatDiscussionId($discutionID)
        ->select('chat_message_duos.*')
        ->simplePaginate($request->has('limit') ? $request->limit : 15);
        return response()->json($messages);
    }

}
