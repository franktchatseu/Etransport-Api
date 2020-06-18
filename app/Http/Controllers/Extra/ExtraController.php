<?php

namespace App\Http\Controllers\Extra;

use Illuminate\Http\Request;
use App\Models\Extra\_Group;
use App\Models\Extra\_Ceb;
use App\Models\Extra\_Post;
use App\Http\Controllers\Controller;

class ExtraController extends Controller
{

    public function getPosts(Request $req)
    {
        $data = _Post::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }

    public function getGroups(Request $req)
    {
        $data = _Group::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }

    public function getCebs(Request $req)
    {
        $data = _Ceb::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }


    
    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = _Post::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

}
