<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use App\Models\Request\AnointingSick;
use Illuminate\Http\Request;

class AnointingSickController extends Controller
{
    /**
     * Display a list of Anointing Sick from database
     * @author Brell Sanwouo
     * @email sanwouobrell@gmail.com
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function index (Request $req)
    {
        $data = AnointingSick::simplePaginate($req->has('limit') ? $req->limit : 15);
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
     * Create an Anointing Sick on database
     * @author Brell Sanwouo
     * @email sanwouobrell@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('photo');

        $this->validate($data, [
            'good_to_know' => 'required',
            'assisted_person' => 'required',
            'age' => 'required',
            'gender' => 'required',
            'quater' => 'required',
            'disease_nature' => 'required',
            'is_baptized' => 'required',
            'request_date' => 'required',
            'avatar' => 'required',
            'comment' => 'required',
            'status' => 'required',
        ]);

            $anointingSick = new AnointingSick();
            $anointingSick->good_to_know = $data['good_to_know'];
            $anointingSick->assisted_person = $data['assisted_person'];
            $anointingSick->age = $data['age'];
            $anointingSick->gender = $data['gender'];
            $anointingSick->quater = $data['quater'];
            $anointingSick->disease_nature = $data['disease_nature'];
            $anointingSick->is_baptized = $data['is_baptized'];
            $anointingSick->request_date = $data['request_date'];
            $anointingSick->avatar = $data['avatar'];
            $anointingSick->comment = $data['comment'];
            $anointingSick->status = $data['status'];
 
            
            $anointingSick->save();
       
        return response()->json($anointingSick);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Request\AnointingSick  $anointingSick
     * @return \Illuminate\Http\Response
     */
    public function show(AnointingSick $anointingSick)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Request\AnointingSick  $anointingSick
     * @return \Illuminate\Http\Response
     */
    public function edit(AnointingSick $anointingSick)
    {
        //
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
        $anointingSick = AnointingSick::find($id);
        if (!$anointingSick) {
            abort(404, "No anointingSick found with id $id");
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'good_to_know' => 'required',
            'assisted_person' => 'required',
            'age' => 'required',
            'gender' => 'required',
            'quater' => 'required',
            'disease_nature' => 'required',
            'is_baptized' => 'required',
            'request_date' => 'required',
            'avatar' => 'required',
        ]);
        
        if (null !== $data['good_to_know']) $anointingSick->good_to_know = $data['good_to_know'];
        if (null !== $data['assisted_person']) $anointingSick->assisted_person = $data['assisted_person'];
        if (null !== $data['age']) $anointingSick->age = $data['age'];
        if (null !== $data['gender']) $anointingSick->gender = $data['gender'];
        if (null !== $data['quater']) $anointingSick->quater = $data['quater'];
        if (null !== $data['disease_nature']) $anointingSick->disease_nature = $data['disease_nature'];
        if (null !== $data['is_baptized']) $anointingSick->is_baptized = $data['is_baptized'];
        if (null !== $data['request_date']) $anointingSick->request_date = $data['request_date'];
        if (null !== $data['avatar']) $anointingSick->avatar = $data['avatar'];
        if (null !== $data['comment']) $anointingSick->comment = $data['comment'];
        if (null !== $data['status']) $anointingSick->status = $data['status'];

        $anointingSick->update();

        return response()->json($anointingSick);
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
        if (!$anointingSick = AnointingSick::find($id)) {
            abort(404, "No anointingSick found with id $id");
        }

        $anointingSick->delete();      
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

        $data = AnointingSick::where($req->field, 'like', "%$req->q%")
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
        if (!$anointingSick = AnointingSick::find($id)) {
            abort(404, "No anointingSick found with id $id");
        }
        return response()->json($anointingSick);
    }
}
