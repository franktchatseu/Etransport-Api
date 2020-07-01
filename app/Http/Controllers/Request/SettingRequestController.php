<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Request\SettingRequest;
use App\Models\APIError;


class SettingRequestController extends Controller
{
   /**
     * Display a list of Anointing Sick from database
     * @author Brell Sanwouo
     * @email sanwouobrell@gmail.com
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = SettingRequest::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }

    /**
     * Create an Anointing Sick on database
     * @author Brell Sanwouo
     * @email sanwouobrell@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datas = $request->all();
        $this->validate($datas, [
            'slug' => 'required',
            'amount' => 'required',
            'goodToKnow' => 'required',
        ]);

        $data = new SettingRequest();
        $data->slug = $datas['slug'];
        $data->amount = $datas['amount'];
        $data->goodToKnow = $datas['goodToKnow'];

        $data->save();

        return response()->json($data);
    }

    /**
     * Update an Anointing Sick on database
     * @author Brell Sanwouo
     * @email sanwouobrell@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $data = SettingRequest::find($id);
        if (!$data) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("SettingRequest_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $datas = $req->all();

        if (null !== $data['slug']) $data->slug = $datas['slug'];
        if (null !== $data['amount']) $data->amount = $datas['amount'];
        if (null !== $data['goodToKnow']) $data->goodToKnow = $datas['goodToKnow'];

        $data->update();

        return response()->json($data);
    }

    /**
     * Remove an Anointing Sick from database
     * @author Brell Sanwouo
     * @email sanwouobrell@gmail.com
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$data = SettingRequest::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("SettingRequest_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data->delete();
        return response()->json();
    }

    /**
     * Search an Anointing Sick from database
     * @author Brell Sanwouo
     * @email sanwouobrell@gmail.com
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = SettingRequest::where($req->field, 'like', "%$req->q%")
            ->get();

        return response()->json($data);
    }

    /**
     * Find an Anointing Sick from database
     * @author Brell Sanwouo
     * @email sanwouobrell@gmail.com
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        if (!$data = SettingRequest::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("SettingRequest_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($data);
    }

    public function findBySlug(Request $req, $id)
    {
        $data = SettingRequest::whereSlug($id)->simplePaginate($req->has('limit') ? $req->limit : 15);
        if (!$data) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("SettingRequest_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($data);
    }
}
