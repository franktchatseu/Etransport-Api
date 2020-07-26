<?php

namespace App\Http\Controllers\Module3;

use App\Http\Controllers\Controller;
use App\Models\Module3\gearpicture;
use Illuminate\Http\Request;

class gearpictureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = gearpicture::orderBy('id', 'desc')->simplePaginate($req->has('limit') ? $req->limit : 15);
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
            'fore_gear' => 'required',
            'rear_gear' => 'required',
            'left_side_gear' => 'required',
            'right_side_gear' => 'required',
            'insurance_patente' => 'required',
            'grey_card' => 'required',
            'stepper_id' => 'required',
        ]);

        /**
         * fore gear
         */
        if (isset($req->fore_gear)) {
            $file = $req->file('fore_gear');
            $path = null;
            if ($file != null) {
                $req->validate(['fore_gear' => 'image|max:20000']);
                $extension = $file->getClientOriginalExtension();
                $relativeDestination = "uploads/pictures/cars";
                $destinationPath = public_path($relativeDestination);
                $safeName = "fore_gear" . time() . '.' . $extension;
                $file->move($destinationPath, $safeName);
                $path = url("$relativeDestination/$safeName");
            }
            $data['fore_gear'] = $path;
        }

        /**
         * rear gear
         */
        if (isset($req->rear_gear)) {
            $file = $req->file('rear_gear');
            $path = null;
            if ($file != null) {
                $req->validate(['rear_gear' => 'image|max:20000']);
                $extension = $file->getClientOriginalExtension();
                $relativeDestination = "uploads/pictures/cars";
                $destinationPath = public_path($relativeDestination);
                $safeName = "rear_gear" . time() . '.' . $extension;
                $file->move($destinationPath, $safeName);
                $path = url("$relativeDestination/$safeName");
            }
            $data['rear_gear'] = $path;
        }

        /**
         * left side gear
         */
        if (isset($req->left_side_gear)) {
            $file = $req->file('left_side_gear');
            $path = null;
            if ($file != null) {
                $req->validate(['left_side_gear' => 'image|max:20000']);
                $extension = $file->getClientOriginalExtension();
                $relativeDestination = "uploads/pictures/cars";
                $destinationPath = public_path($relativeDestination);
                $safeName = "left_side_gear" . time() . '.' . $extension;
                $file->move($destinationPath, $safeName);
                $path = url("$relativeDestination/$safeName");
            }
            $data['left_side_gear'] = $path;
        }

        /**
         * right side gear
         */
        if (isset($req->right_side_gear)) {
            $file = $req->file('right_side_gear');
            $path = null;
            if ($file != null) {
                $req->validate(['right_side_gear' => 'image|max:20000']);
                $extension = $file->getClientOriginalExtension();
                $relativeDestination = "uploads/pictures/cars";
                $destinationPath = public_path($relativeDestination);
                $safeName = "right_side_gear" . time() . '.' . $extension;
                $file->move($destinationPath, $safeName);
                $path = url("$relativeDestination/$safeName");
            }
            $data['right_side_gear'] = $path;
        }

        /**
         * insurance patente
         */
        if (isset($req->insurance_patente)) {
            $file = $req->file('insurance_patente');
            $path = null;
            if ($file != null) {
                $req->validate(['insurance_patente' => 'image|max:20000']);
                $extension = $file->getClientOriginalExtension();
                $relativeDestination = "uploads/pictures/cars";
                $destinationPath = public_path($relativeDestination);
                $safeName = "insurance_patente" . time() . '.' . $extension;
                $file->move($destinationPath, $safeName);
                $path = url("$relativeDestination/$safeName");
            }
            $data['insurance_patente'] = $path;
        }

        /**
         * grey card
         */
        if (isset($req->grey_card)) {
            $file = $req->file('grey_card');
            $path = null;
            if ($file != null) {
                $req->validate(['grey_card' => 'image|max:20000']);
                $extension = $file->getClientOriginalExtension();
                $relativeDestination = "uploads/pictures/cars";
                $destinationPath = public_path($relativeDestination);
                $safeName = "grey_card" . time() . '.' . $extension;
                $file->move($destinationPath, $safeName);
                $path = url("$relativeDestination/$safeName");
            }
            $data['grey_card'] = $path;
        }

        $gearpicture = new gearpicture();
        $gearpicture->fore_gear = $data['fore_gear'];
        $gearpicture->rear_gear = $data['rear_gear'];
        $gearpicture->left_side_gear = $data['left_side_gear'];
        $gearpicture->right_side_gear = $data['right_side_gear'];
        $gearpicture->insurance_patente = $data['insurance_patente'];
        $gearpicture->grey_card = $data['grey_card'];
        $gearpicture->stepper_id = $data['stepper_id'];
        $gearpicture->save();

        return response()->json($gearpicture);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Module3\gearpicture  $gearpicture
     * @return \Illuminate\Http\Response
     */
    public function show(gearpicture $gearpicture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Module3\gearpicture  $gearpicture
     * @return \Illuminate\Http\Response
     */
    public function edit(gearpicture $gearpicture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Module3\gearpicture  $gearpicture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $gearpicture = gearpicture::find($id);
        if (!$gearpicture) {
            abort(404, "No gearpicture found with id $id");
        }

        $data = $req->except('');

        /**
         * fore gear
         */
        if (isset($req->fore_gear)) {
            $file = $req->file('fore_gear');
            $path = null;
            if ($file != null) {
                $req->validate(['fore_gear' => 'image|max:20000']);
                $extension = $file->getClientOriginalExtension();
                $relativeDestination = "uploads/pictures/cars";
                $destinationPath = public_path($relativeDestination);
                $safeName = "fore_gear" . time() . '.' . $extension;
                $file->move($destinationPath, $safeName);
                $path = url("$relativeDestination/$safeName");
                if ($gearpicture->fore_gear) {
                    $oldImagePath = public_path($gearpicture->fore_gear);
                    if (file_exists($oldImagePath)) {
                        @unlink($oldImagePath);
                    }
                }
            }
            $data['fore_gear'] = $path;
        }

        /**
         * rear gear
         */
        if (isset($req->rear_gear)) {
            $file = $req->file('rear_gear');
            $path = null;
            if ($file != null) {
                $req->validate(['rear_gear' => 'image|max:20000']);
                $extension = $file->getClientOriginalExtension();
                $relativeDestination = "uploads/pictures/cars";
                $destinationPath = public_path($relativeDestination);
                $safeName = "rear_gear" . time() . '.' . $extension;
                $file->move($destinationPath, $safeName);
                $path = url("$relativeDestination/$safeName");
                if ($gearpicture->rear_gear) {
                    $oldImagePath = public_path($gearpicture->rear_gear);
                    if (file_exists($oldImagePath)) {
                        @unlink($oldImagePath);
                    }
                }
            }
            $data['rear_gear'] = $path;
        }

        /**
         * left side gear
         */
        if (isset($req->left_side_gear)) {
            $file = $req->file('left_side_gear');
            $path = null;
            if ($file != null) {
                $req->validate(['left_side_gear' => 'image|max:20000']);
                $extension = $file->getClientOriginalExtension();
                $relativeDestination = "uploads/pictures/cars";
                $destinationPath = public_path($relativeDestination);
                $safeName = "left_side_gear" . time() . '.' . $extension;
                $file->move($destinationPath, $safeName);
                $path = url("$relativeDestination/$safeName");
                if ($gearpicture->left_side_gear) {
                    $oldImagePath = public_path($gearpicture->left_side_gear);
                    if (file_exists($oldImagePath)) {
                        @unlink($oldImagePath);
                    }
                }
            }
            $data['left_side_gear'] = $path;
        }

        /**
         * right side gear
         */
        if (isset($req->right_side_gear)) {
            $file = $req->file('right_side_gear');
            $path = null;
            if ($file != null) {
                $req->validate(['right_side_gear' => 'image|max:20000']);
                $extension = $file->getClientOriginalExtension();
                $relativeDestination = "uploads/pictures/cars";
                $destinationPath = public_path($relativeDestination);
                $safeName = "right_side_gear" . time() . '.' . $extension;
                $file->move($destinationPath, $safeName);
                $path = url("$relativeDestination/$safeName");
                if ($gearpicture->right_side_gear) {
                    $oldImagePath = public_path($gearpicture->right_side_gear);
                    if (file_exists($oldImagePath)) {
                        @unlink($oldImagePath);
                    }
                }
            }
            $data['right_side_gear'] = $path;
        }

        /**
         * insurance patente
         */
        if (isset($req->insurance_patente)) {
            $file = $req->file('insurance_patente');
            $path = null;
            if ($file != null) {
                $req->validate(['insurance_patente' => 'image|max:20000']);
                $extension = $file->getClientOriginalExtension();
                $relativeDestination = "uploads/pictures/cars";
                $destinationPath = public_path($relativeDestination);
                $safeName = "insurance_patente" . time() . '.' . $extension;
                $file->move($destinationPath, $safeName);
                $path = url("$relativeDestination/$safeName");
                if ($gearpicture->insurance_patente) {
                    $oldImagePath = public_path($gearpicture->insurance_patente);
                    if (file_exists($oldImagePath)) {
                        @unlink($oldImagePath);
                    }
                }
            }
            $data['insurance_patente'] = $path;
        }

        /**
         * grey card
         */
        if (isset($req->grey_card)) {
            $file = $req->file('grey_card');
            $path = null;
            if ($file != null) {
                $req->validate(['grey_card' => 'image|max:20000']);
                $extension = $file->getClientOriginalExtension();
                $relativeDestination = "uploads/pictures/cars";
                $destinationPath = public_path($relativeDestination);
                $safeName = "grey_card" . time() . '.' . $extension;
                $file->move($destinationPath, $safeName);
                $path = url("$relativeDestination/$safeName");
                if ($gearpicture->grey_card) {
                    $oldImagePath = public_path($gearpicture->grey_card);
                    if (file_exists($oldImagePath)) {
                        @unlink($oldImagePath);
                    }
                }
            }
            $data['grey_card'] = $path;
        }


        if ($data['fore_gear'] ?? null ) $gearpicture->fore_gear = $data['fore_gear'];
        if ($data['rear_gear'] ?? null ) $gearpicture->rear_gear = $data['rear_gear'];
        if ($data['left_side_gear'] ?? null ) $gearpicture->left_side_gear = $data['left_side_gear'];
        if ($data['right_side_gear'] ?? null ) $gearpicture->right_side_gear = $data['right_side_gear'];
        if ($data['insurance_patente'] ?? null ) $gearpicture->insurance_patente = $data['insurance_patente'];
        if ($data['grey_card'] ?? null ) $gearpicture->grey_card = $data['grey_card'];
        if ($data['stepper_id'] ?? null ) $gearpicture->stepper_id = $data['stepper_id'];

        $gearpicture->update();

        return response()->json($gearpicture);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Module3\gearpicture  $gearpicture
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$gearpicture = gearpicture::find($id)) {
            abort(404, "No gearpicture found with id $id");
        }

        $gearpicture->delete();
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = gearpicture::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        if (!$gearpicture = gearpicture::find($id)) {
            abort(404, "No gearpicture found with id $id");
        }
        return response()->json($gearpicture);
    }
}
