<?php

namespace App\Http\Controllers\Person;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Person\Catechist;

class CatechistController extends Controller
{
    // public function index(Request $req){
    //     $data = Catechist::simplePaginate($req->has('limit') ? $req-limit : 15);
    // }

    public function get(Request $req) {
        $s = $req->s;
        $page = $req->page;
        $limit = null;

        if ($req->limit && $req->limit > 0) {
            $limit = $req->limit;
        }

        if ($s) {
            if ($limit || $page) {
                $catechist = Catechist::where('catechist_date', 'LIKE', '%' . $s . '%')
                                    ->orWhere('catechist_place', 'LIKE', '%' . $s . '%')
                                    ->paginate($limit);
            } else {
                $catechist = Catechist::where('catechist_date', 'LIKE', '%' . $s . '%')
                                    ->orWhere('catechist_place', 'LIKE', '%' . $s . '%')
                                    ->orWhere('type', 'LIKE', '%' . $s . '%')
                                    ->get();
            }
        } else {
            if ($limit || $page) {
                $catechist = Catechist::paginate($limit);
            } else {
                $catechist = Catechist::all();
            }
        }

        return response()->json($catechist);
    }

    // public function search(Request $req)
    // {
    //     $this->validate($req->all(), [
    //         'q' => 'present',
    //         'field' => 'present'
    //     ]);

    //     $data = Catechist::where($req->field, 'like', "%$req->q%")
    //         ->get();

    //     return response()->json($data);
    // }

    public function find($id)
    {
        $catechist = Catechist::find($id);
        if (!$catechist) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CATHECHIST_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($catechist);
    }

    public function destroy($id)
    {
        $catechist = Catechist::find($id);
        if (!$catechist) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CATHECHIST_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $catechist->delete();      
        return response()->json();
    }

    public function update(Request $req, $id)
    {
        $catechist = Catechist::find($id);
        if (!$catechist) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CATHECHIST_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        
        $catechist->update();
        return response()->json($catechist);
    }
}
