<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Models\Notification\UserParishionalMessage;
use App\Models\Person\User;
use App\Models\APIError;
use Illuminate\Http\Request;

class UserParishionalMessageController extends Controller
{
    public function index(Request $req)
    {
        $data = UserParishionalMessage::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }

    public function find($id)
    {
        if (!$user = User::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("USER_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        return response()->json($user->parishionalMessages);
    }
}
