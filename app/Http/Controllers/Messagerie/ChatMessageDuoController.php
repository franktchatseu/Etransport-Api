<?php

namespace App\Http\Controllers\Messagerie;

use App\Models\APIError;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Messagerie\ChatMessageDuo;

class ChatMessageDuoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = ChatMessageDuo::simplePaginate($req->has('limit') ? $req->limit : 15);
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
        $data = $req->except('files');

        $this->validate($data, [
            'chat_discussion_id' => 'required:exists:chat_discussions,id',
            'sender_id' => 'required:exists:chat_member_groups,id',
        ]);

        if ( $req->file('files') ?? null) {
            $filePaths = $this->saveSingleImage($this, $req, 'files', 'message_duos');
            $data['files'] = json_encode(['images' => $filePaths]);
        }

        $message = new ChatMessageDuo();
        $message->chat_discussion_id = $data['chat_discussion_id'];
        $message->sender_id = $data['sender_id'];
        $message->content = $data['content'];
        $message->parent_id = $data['parent_id'] ?? null;
        $message->received_at = $data['received_at'] ?? null;
        $message->sender_delete_at = $data['sender_delete_at'] ?? null;
        $message->receiver_delete_at = $data['receiver_delete_at'] ?? null;
        $message->viewed_at = $data['viewed_at'] ?? null;
        $message->files = $data['files'] ?? null;
        $message->save();
       
        return response()->json($message);
    }

    public function update(Request $req, $id)
    {
        $message = ChatMessageDuo::find($id);
        if (!$message) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CHATMESSAGEDUO_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->all();
        
        if ($data['content'] ?? null) $message->content = $data['content'];
        if ($data['parent_id'] ?? null) $message->parent_id = $data['parent_id'];
        if ($data['received_at'] ?? null) $message->received_at = $data['received_at'];
        if ($data['sender_delete_at'] ?? null) $message->sender_delete_at = $data['sender_delete_at'];
        if ($data['receiver_delete_at'] ?? null) $message->receiver_delete_at = $data['receiver_delete_at'];
        if ($data['viewed_at'] ?? null) $message->viewed_at = $data['viewed_at'];
        
        $message->update();
        return response()->json($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Place\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = ChatMessageDuo::find($id);
        if (!$message) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CHATMESSAGEDUO_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        $message->delete();      
        return response()->json();
    }

    public function find($id)
    {
        $message = ChatMessageDuo::find($id);
        if (!$message) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CHATMESSAGEDUO_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($message);
    }

    public function search(Request $req, $id)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = ChatMessageDuo::where([
            [$req->field, 'like', "%$req->q%"],
            ['chat_discussion_id', $id]
            ])
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

}
