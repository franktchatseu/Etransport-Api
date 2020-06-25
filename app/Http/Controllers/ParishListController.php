<?php

namespace App\Http\Controllers;

use App\Models\Setting\Parish;
use Illuminate\Http\Request;

class ParishListController extends Controller
{
    public function index(Request $request, $limit)
    { 
        {
            $data = Parish::simplePaginate($request->has('limit') ? $request->limit : $limit);
            return response()->json($data);
        }
    }
    public function all(Request $request)
    { 
        {
            $data = Parish::all();
            return response()->json($data);
        }
    }



}
