<?php

namespace App\Http\Controllers\Messagerie;

use App\Models\APIError;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Messagerie\ChatMessageGroup;

class ChatMessageGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = ChatMessageGroup::simplePaginate($req->has('limit') ? $req->limit : 15);
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
            'sender_id' => 'required:exists:chat_member_groups,id',
            'sender_name' => 'required',
        ]);

        if ( $req->file('files') ?? null) {
            $filePaths = $this->saveSingleImage($this, $req, 'files', 'message_groups');
            $data['files'] = json_encode(['images' => $filePaths]);
        }

        $message = new ChatMessageGroup();
        $message->sender_id = $data['sender_id'];
        $message->sender_name = $data['sender_name'];
        $message->files = $data['files'] ?? null;
        $message->message = $data['message'] ?? null;
        $message->save();
       
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
        $message = ChatMessageGroup::find($id);
        if (!$message) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CHATMESSAGEGROUP_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $message->delete();      
        return response()->json();
    }

}
