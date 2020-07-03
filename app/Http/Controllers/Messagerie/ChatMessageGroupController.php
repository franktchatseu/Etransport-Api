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
            'group_id' => 'required',
        ]);

        if ( $req->file('images') ?? null) {
            $filePaths = $this->saveSingleImage($this, $req, 'images', 'message_groups');
            $data['images'] = json_encode(['images' => $filePaths]);
        }

         if($req->files){
            $files = $req->file('files');
            $path = null;
            if($files != null){
                $extension = $files->getClientOriginalExtension();
                $relativeDestination = "uploads/Files-Discussions";
                $destinationPath = public_path($relativeDestination);
                $safeName = "document".time().'.'.$extension;
                $files->move($destinationPath, $safeName);
                $path = "$relativeDestination/$safeName";
            }
            $data['files'] = url($path);
        }

        $message = new ChatMessageGroup();
        $message->sender_id = $data['sender_id'];
        $message->sender_name = $data['sender_name'];
        $message->group_id = $data['group_id'];
        $message->files = $data['files'] ?? null;
        $message->images = $data['images'] ?? null;
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
