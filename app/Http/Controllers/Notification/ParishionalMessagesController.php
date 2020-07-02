<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Models\Notification\ParishionalMessages;
use App\Models\APIError;
use Illuminate\Http\Request;

class ParishionalMessagesController extends Controller
{
    public function index(Request $req)
    {
        $data = ParishionalMessages::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }

    public function create(Request $req)
    {
        $data = $req->all();

        $this->validate($data, [
            'title' => 'required|string',
            'type' => 'required|string',
            'description' => 'required|string',
            'effective_date' => 'required'
        ]);

        if ($file = $req->file('photo')) {
            $filePaths = $this->saveSingleImages($this, $req, 'photo', 'parishional-messages');
            $data['photo'] = json_encode(['images' => $filePaths]);
        }

        $parishional_message = new ParishionalMessages();
        $parishional_message->title = $data['title'];
        $parishional_message->type = $data['type'];
        $parishional_message->description = $data['description'];
        $parishional_message->photo = $data['photo'];
        $parishional_message->begin_hour = date($data['begin_hour']);

        $parishional_message->save();
        return response()->json($parishional_message, 201);
    }

    public function find($id)
    {
        if (!$parishional_message = ParishionalMessages::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PARISHIONAL_MESSAGE_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        return response()->json($parishional_message);
    }

    public function update(Request $req, $id)
    {
        $parishional_message = ParishionalMessages::find($id);
        if (!$parishional_message) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PARISHIONAL_MESSAGE_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->except('photo');

        if ($file = $req->file('photo')) {
            $filePaths = $this->saveMultipleImages($this, $req, 'photo', 'parishional-messages');
            $data['photos'] = json_encode(['images' => $filePaths]);
        }

        if (isset($data['photo'])) $parishional_message->photo = $data['photo'];
        if (isset($data['title'])) $parishional_message->title = $data['title'];
        if (isset($data['type'])) $parishional_message->type = $data['type'];
        if (isset($data['description'])) $parishional_message->description = $data['description'];
        if (isset($data['begin_hour'])) $parishional_message->begin_hour = date($data['begin_hour']);

        $parishional_message->update();

        return response()->json($parishional_message);
    }

    public function destroy($id)
    {
        if (!$parishional_message = ParishionalMessages::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PARISHIONAL_MESSAGE_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        $parishional_message->delete();

        return response()->json();
    }
}
