<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\RequestForMass;
use Illuminate\Http\Request;
use App\Models\APIError;

class RequestForMassController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function index (Request $req)
    {
        $data = RequestForMass::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Create a request For Mass on database
     * @author jiozang theophane
     * @email jiozangtheophane@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('photo');

        $this->validate($data, [
            'title' => 'required',
            'description' => 'required'
        ]);

            $requestForMass = new RequestForMass();
            $requestForMass->title = $data['title'];
            $requestForMass->description = $data['description'];
            $requestForMass->save();
       
        return response()->json($requestForMass);
    }

    /**
     * Create a request For Mass on database
     * @author jiozang theophane
     * @email jiozangtheophane@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(RequestForMass $requestForMass)
    {
        //
    }

    /**
     * Create a request For Mass on database
     * @author jiozang theophane
     * @email jiozangtheophane@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(RequestForMass $requestForMass)
    {
        //
    }

    
   /**
     * Create a request For Mass on database
     * @author jiozang theophane
     * @email jiozangtheophane@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $requestForMass = RequestForMass::find($id);
        if($requestForMass == null) {
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("REQUESTFORMASS_NOT_FOUND");
            $notFound->setMessage("requestForMass with id " . $id . " not found");

            return response()->json($notFound, 404);
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'title' => 'required',
            'description' => 'required'
        ]);

        if (null !== $data['title']) $requestForMass->title = $data['title'];
        if (null !== $data['description']) $requestForMass->description = $data['description'];
        
        $requestForMass->update();

        return response()->json($requestForMass);
    }

    /**
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $requestForMass = RequestForMass::find($id);
        if($requestForMass == null) {
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("REQUESTFORMASS_NOT_FOUND");
            $notFound->setMessage("requestForMass with id " . $id . " not found");

            return response()->json($notFound, 404);
        }

        $requestForMass->delete();      
        return response()->json();
    }
/**
     * Create a request For Mass on database
     * @author jiozang theophane
     * @email jiozangtheophane@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = RequestForMass::where($req->field, 'like', "%$req->q%")
        ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    /**
     * Create a request For Mass on database
     * @author jiozang theophane
     * @email jiozangtheophane@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $requestForMass = RequestForMass::find($id);
        if($requestForMass == null) {
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("REQUESTFORMASS_NOT_FOUND");
            $notFound->setMessage("requestForMass with id " . $id . " not found");

            return response()->json($notFound, 404);
        }
        return response()->json($requestForMass);
    }
}
