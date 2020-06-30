<?php

namespace App\Http\Controllers\Publicity;

use App\Http\Controllers\Controller;
use App\Models\Publicity\Publicity;
use Illuminate\Http\Request;
use App\Models\APIError;
use Carbon\Carbon;

class PublicityController extends Controller
{
  
    public function index(Request $req)
    {
        $data = Publicity::orderBy('view_numbers','asc')->orderBy('priority','desc')->inRandomOrder()->simplePaginate($req->has('limit') ? $req->limit : 4);
        foreach($data as $pub){
            $pub['view_numbers'] = $pub['view_numbers']+1;
            $pub->update();
        }
        return response()->json($data);
    }

    public function create(Request $req)
    {
        $data = $req->except('photos');

        $this->validate($data, [
            'name' => 'required',
            'priority' => 'required',
            'date_end' => 'required'
        ]);

        if ($file = $req->file('photos')) {
            $filePaths = $this->saveMultipleImages($this, $req, 'photos', 'publicities');
            $data['photos'] = json_encode(['images' => $filePaths]);
        }

        $publicity = new Publicity();
        $publicity->name = $data['name'];
        $publicity->priority = $data['priority'];
        $publicity->photos = $data['photos'];
        $publicity->date_end = date($data['date_end']);

        $publicity->save();
        return response()->json($publicity, 201);
    }

    public function find($id)
    {
        if (!$publicity = Publicity::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PUBLICITY_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        return response()->json($publicity);
    }

    public function update(Request $req, $id)
    {
        $publicity = Publicity::find($id);
        if (!$publicity) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PUBLICITY_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->except('photos');

        if ($file = $req->file('photos')) {
            $filePaths = $this->saveMultipleImages($this, $req, 'photos', 'publicities');
            $data['photos'] = json_encode(['images' => $filePaths]);
        }

        if (isset($data['name'])) $publicity->name = $data['name'];
        if (isset($data['date_end'])) $publicity->date_end = date($data['date_end']);
        if (isset($data['description'])) $publicity->date_end = date($data['description']);

        $publicity->update();

        return response()->json($publicity);
    }

    public function destroy($id)
    {
        if (!$publicity = Publicity::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PUBLICITY_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        $publicity->delete();

        return response()->json();
    }
}
