<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\Nature;
use Illuminate\Http\Request;
use App\Models\APIError;

class NatureController extends Controller
{
    /**
     * Display a listing of the resource.
     * @author Arleon Zemtsop
     * @email arleonzemtsop@gmail.com
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Nature::simplePaginate($req->has('limit') ? $req->limit : 15);
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
     * Store a newly created resource in storage.
     * @author Arleon Zemtsop
     * @email arleonzemtsop@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('photo');

        $this->validate($data, [
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
            'amount' => 'required'
        ]);

        $nature = new Nature();
        $nature->name = $data['name'];
        $nature->description = $data['description'];
        $nature->status = $data['status'];
        $nature->amount = $data['amount'];
        $nature->save();
       
        return response()->json($nature);
    }

    /**
     * Display the specified resource.
     * @author Arleon Zemtsop
     * @email arleonzemtsop@gmail.com
     * @param  \App\Models\Finance\Nature  $nature
     * @return \Illuminate\Http\Response
     */
    public function show(Nature $nature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @author Arleon Zemtsop
     * @email arleonzemtsop@gmail.com
     * @param  \App\Models\Finance\Nature  $nature
     * @return \Illuminate\Http\Response
     */
    public function edit(Nature $nature)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @author Arleon Zemtsop
     * @email arleonzemtsop@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Finance\Nature  $nature
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $nature = Nature::find($id);
        if($nature == null) {
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("NATURE_NOT_FOUND");
            $notFound->setMessage("nature with id " . $id . " not found");

            return response()->json($notFound, 404);
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
            'amount' => 'required'
        ]);

        if ( $data['name']) $nature->name = $data['name'];
        if ( $data['description']) $nature->description = $data['description'];
        if ( $data['status']) $nature->status = $data['status'];
        if ( $data['amount']) $nature->amount = $data['amount'];
        
        $nature->update();

        return response()->json($nature);
    }

    /**
     * Remove the specified resource from storage.
     * @author Arleon Zemtsop
     * @email arleonzemtsop@gmail.com
     * @param  \App\Models\Finance\Nature  $nature
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $nature = Nature::find($id);
        if($nature == null) {
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("NATURE_NOT_FOUND");
            $notFound->setMessage("nature with id " . $id . " not found");

            return response()->json($notFound, 404);
        }

        $nature->delete();      
        return response()->json();
    }

    /**
     * Search a nature nature from database
     * @author Arleon Zemtsop
     * @email arleonzemtsop@gmail.com
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Nature::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    /**
     * Find a nature nature from database
     * @author Arleon Zemtsop
     * @email arleonzemtsop@gmail.com
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function getByCategorie(Request $req)
    {
            
        if ($req->name && (Nature::whereName($req->name)->first() != null)) {
            $data = Nature::whereName($req->name)->simplePaginate($req->has('limit') ? $req->limit : 15)->groupBy('status');
            return response()->json($data);
        }else{
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("NANE_NOT_FOUND");
            $notFound->setMessage("nature with name " . $req->name . " not found");
            return response()->json($notFound, 404);
        }
    }

    public function find($id)
    {
        $nature = Nature::find($id);
        if($nature == null) {
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("NATURE_NOT_FOUND");
            $notFound->setMessage("nature with id " . $id . " not found");

            return response()->json($notFound, 404);
        }
        return response()->json($nature);
    }
}
