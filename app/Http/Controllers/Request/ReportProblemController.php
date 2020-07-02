<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Request\ReportProblem;
use App\Models\APIError;

class ReportProblemController extends Controller
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
        $data = ReportProblem::simplePaginate($req->has('limit') ? $req->limit : 15);
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
        $datas = $request->except('photo');
        $this->validate($datas, [
            'nature' => 'required',
            'concern' => 'required',
            'details' => 'required',
            'person_id' => 'required'
        ]);

        if ($request->file('image') ?? null) {
            $filePaths = $this->saveSingleImage($this, $request, 'image', 'report_problems');
            $datas['image'] = json_encode(['images' => $filePaths]);
        }

        $data = new ReportProblem();
        $data->nature = $datas['nature'];
        $data->concern = $datas['concern'];
        $data->details = $datas['details'];
        $data->image = $datas['image'] ?? null;
        $data->status = 'PENDING';
        $data->person_id = $datas['person_id'];

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
        $data = ReportProblem::find($id);
        if (!$data) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ReportProblem_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $datas = $req->except('photo');

        if ($file = $req->file('image')) {
            $filePaths = $this->saveSingleImage($this, $req, 'image', 'report_problems');
            $datas['image'] = json_encode(['images' => $filePaths]);
        }

        if (null !== $datas['image']) $data->image = $datas['image'];
        if (null !== $data['nature']) $data->nature = $datas['nature'];
        if (null !== $data['concern']) $data->concern = $datas['concern'];
        if (null !== $data['details']) $data->details = $datas['details'];
        if (null !== $data['status']) $data->status = $datas['status'];

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
        if (!$data = ReportProblem::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ReportProblem_NOT_FOUND");
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

        $data = ReportProblem::where($req->field, 'like', "%$req->q%")
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
        if (!$data = ReportProblem::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ReportProblem_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($data);
    }

    public function findAllForUser(Request $req, $id)
    {
        $data = ReportProblem::wherePerson_id($id)->simplePaginate($req->has('limit') ? $req->limit : 15);
        if (!$data) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ReportProblem_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($data);
    }
}
