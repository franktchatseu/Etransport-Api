<?php

namespace App\Http\Controllers\Module2;

use App\Http\Controllers\Controller;
use App\Models\Module2\General_Info;
use Illuminate\Http\Request;
use App\Models\APIError;

class General_InfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = General_Info::Select('general_infos.*','nationalities.name','stepper_drivers.*')
        ->join('nationalities','general_infos.nationality_id','=','nationalities.id')
        ->join('stepper_drivers','general_infos.stepper_id','=','stepper_drivers.id')
        ->simplePaginate($req->has('limit') ? $req->limit : 15);
    return response()->json($data);
    }

    public function allWithName(Request $req)
    {
        $data = General_Info::Select('general_infos.*','nationalities.name','stepper_drivers.number','stepper_drivers.value','stepper_drivers.status')
                              ->join('nationalities','general_infos.nationality_id','=','nationalities.id')
                              ->join('stepper_drivers','general_infos.stepper_id','=','stepper_drivers.id')
                              ->simplePaginate($req->has('limit') ? $req->limit : 15);
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $data = $req->except('');

        $this->validate($data, [
            'first_name' => 'required',
            'last_name' => 'required',
            'date_birth' => 'required',
            'place_birth' => 'required',
            'email' => 'required',
            'tel1' => 'required',
            'tel2' => 'required',
            'address' => 'required',
            'avatar' => 'required',
            'nationality_id' => 'required:exists:nationalities,id',
            'stepper_id' => 'required:exists:stepper_drivers,id',
        ]);

        if (isset($req->avatar)) {
            $file = $req->file('avatar');
            $path = null;
            if ($file != null) {
                $req->validate(['avatar' => 'image|max:20000']);
                $extension = $file->getClientOriginalExtension();
                $relativeDestination = "uploads/pictures/drivers";
                $destinationPath = public_path($relativeDestination);
                $safeName = "avatar" . time() . '.' . $extension;
                $file->move($destinationPath, $safeName);
                $path = url("$relativeDestination/$safeName");
            }
            $data['avatar'] = $path;
        }


        $General_Info = new General_Info();
        $General_Info->first_name = $data['first_name'];
        $General_Info->last_name = $data['last_name'];
        $General_Info->date_birth = $data['date_birth'];
        $General_Info->place_birth = $data['place_birth'];
        $General_Info->email = $data['email'];
        $General_Info->tel1 = $data['tel1'];
        $General_Info->tel2 = $data['tel2'];
        $General_Info->address = $data['address'];
        $General_Info->avatar = $data['avatar'];
        $General_Info->nationality_id = $data['nationality_id'];
        $General_Info->stepper_id = $data['stepper_id'];
        $General_Info->save();

        return response()->json($General_Info);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Module2\General_Info  $general_Info
     * @return \Illuminate\Http\Response
     */
    public function show(General_Info $general_Info)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Module2\General_Info  $general_Info
     * @return \Illuminate\Http\Response
     */
    public function edit(General_Info $general_Info)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Module2\General_Info  $general_Info
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $General_Info = General_Info::find($id);
        if (!$General_Info) {
            abort(404, "No General_Info found with id $id");
        }

        $data = $req->except('');

        if (isset($req->avatar)) {
            $file = $req->file('avatar');
            $path = null;
            if ($file != null) {
                $req->validate(['avatar' => 'image|max:20000']);
                $extension = $file->getClientOriginalExtension();
                $relativeDestination = "uploads/pictures/cars";
                $destinationPath = public_path($relativeDestination);
                $safeName = "avatar" . time() . '.' . $extension;
                $file->move($destinationPath, $safeName);
                $path = url("$relativeDestination/$safeName");
                if ($General_Info->avatar) {
                    $oldImagePath = public_path($General_Info->avatar);
                    if (file_exists($oldImagePath)) {
                        @unlink($oldImagePath);
                    }
                }
            }
            $data['avatar'] = $path;
        }


        if ( $data['first_name'] ?? null) $General_Info->first_name = $data['first_name'];
        if ( $data['last_name'] ?? null) $General_Info->last_name = $data['last_name'];
        if ( $data['date_birth'] ?? null) $General_Info->date_birth = $data['date_birth'];
        if ( $data['place_birth'] ?? null) $General_Info->place_birth = $data['place_birth'];
        if ( $data['email'] ?? null) $General_Info->email = $data['email'];
        if ( $data['tel1'] ?? null) $General_Info->tel1 = $data['tel1'];
        if ( $data['tel2'] ?? null) $General_Info->tel2 = $data['tel2'];
        if ( $data['address'] ?? null) $General_Info->address = $data['address'];
        if ( $data['avatar'] ?? null) $General_Info->avatar = $data['avatar'];
        if ( $data['nationality_id'] ?? null) $General_Info->nationality_id = $data['nationality_id'];
        if ( $data['stepper_id'] ?? null) $General_Info->stepper_id = $data['stepper_id'];
        
        $General_Info->update();

        return response()->json($General_Info);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Module2\General_Info  $general_Info
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$General_Info = General_Info::find($id)) {
            abort(404, "No General_Info found with id $id");
        }

        $General_Info->delete();
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = General_Info::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        if (!$General_Info = General_Info::find($id)) {
            abort(404, "No General_Info found with id $id");
        }
        return response()->json($General_Info);
    }

    public function finds($id, Request $req)
    {
        if (!$General_Info = General_Info::find($id)) {
            abort(404, "No General_Info found with id $id");
        }
        
        $data = General_Info::Select('general_infos.*','nationalities.name','stepper_drivers.*')
                              ->join('nationalities','general_infos.nationality_id','=','nationalities.id')
                              ->join('stepper_drivers','general_infos.stepper_id','=','stepper_drivers.id')
                              ->where(['general_infos.id' => $id])
                              ->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }
}

