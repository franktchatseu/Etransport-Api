<?php

namespace App\Http\Controllers\Module1;

use App\Http\Controllers\Controller;
use App\Models\Module1\PersonalComputingSpecial;
use Illuminate\Http\Request;
use App\Models\APIError;

class PersonalComputingSpecialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        //
        $data = PersonalComputingSpecial::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $data = $request->all();
        $this->validate($data, [
            'surmane' => 'required',
            'stepper_id' => 'required',
            'tel2' => 'required',
            'email' => 'required',
            'langue' => 'required',
            'tel1' => 'required',
            'image' => 'required',
            'adress' => 'required',
            'gear_count' => 'required',
            'driver_number' => 'required',
            'name' => 'required',
        ]);


        $personal = new PersonalComputingSpecial();
        $personal->surmane = $data['surmane'];
        $personal->stepper_id = $data['stepper_id'];
        $personal->tel2 = $data['tel2'];
        $personal->email = $data['email'];
        $personal->langue = $data['langue'];
        $personal->tel1 = $data['tel1'];
        $personal->adress = $data['adress'];
        $personal->gear_count = $data['gear_count'];
        $personal->driver_number = $data['driver_number'];
        $personal->name = $data['name'];

        if (isset($request->image)) {
            $file = $request->file('image');
            $path = null;
            if ($file != null) {
                $request->validate(['image' => 'image|max:20000']);
                $extension = $file->getClientOriginalExtension();
                $relativeDestination = "uploads/e-transport/personal_computing_special/documents";
                $destinationPath = public_path($relativeDestination);
                $safeName = "image" . time() . '.' . $extension;
                $file->move($destinationPath, $safeName);
                $path = url("$relativeDestination/$safeName");
            }
            $data['image'] = $path;
            $personal->image = $data['image'];
        }

        $personal->save();
       
        return response()->json($personal);
    }

    /**
     * Search the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = PersonalComputingSpecial::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    /**
     * Bill the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $personal = PersonalComputingSpecial::find($id);
        if (!$personal) {

            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PERSONAL_COMPUTING_SPECIAL");
            return response()->json($apiError, 404);
        }

        return response()->json($personal);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $personal = PersonalComputingSpecial::find($id);
        if (!$personal) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PERSONAL_COMPUTING_SPECIAL");

            return response()->json($apiError, 404);
        }

        $data = $request->all();

        if ( $request->surmane ?? null) $personal->surmane = $data['surmane'];
        if ( $request->stepper_id ?? null ) $personal->stepper_id = $data['stepper_id'];
        if ( $request->tel2 ?? null) $personal->tel2 = $data['tel2'];
        if ( $request->email ?? null) $personal->email = $data['email'];
        if ( $request->langue ?? null) $personal->langue = $data['langue'];
        if ( $request->tel1 ?? null) $personal->tel1 = $data['tel1'];
        if ( $request->image ?? null) 
        {
            $file = $request->file('image');
            $path = null;
            if ($file != null) {
                $request->validate(['image' => 'image|max:20000']);
                $extension = $file->getClientOriginalExtension();
                $relativeDestination = "uploads/e-transport/personal_computing_special/documents";
                $destinationPath = public_path($relativeDestination);
                $safeName = "image" . time() . '.' . $extension;
                $file->move($destinationPath, $safeName);
                $path = url("$relativeDestination/$safeName");
                if ($personal->image) {
                    $oldImagePath = public_path($personal->image);
                    if (file_exists($oldImagePath)) {
                        @unlink($oldImagePath);
                    }
                }
            }
            $data['image'] = $path;
            $personal->image = $data['image'];
        }
        if ( $request->adress ?? null) $personal->adress = $data['adress'];
        if ( $request->gear_count ?? null) $personal->gear_count = $data['gear_count'];
        if ( $request->driver_number ?? null) $personal->driver_number = $data['driver_number'];
        if ( $request->name ?? null) $personal->name = $data['name'];

        $personal->update();

        return response()->json($personal);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $personal = PersonalComputingSpecial::find($id);
        if (!$personal) {

            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PERSONAL_COMPUTING_SPECIAL");
            return response()->json($apiError, 404);
        }

        $personal->delete();      
        return response()->json();
    }
}
