<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\APIError;
use App\Models\Setting\Album;
use App\Models\Setting\Photo;
use App\Models\Setting\Contact;
use App\Models\Setting\MassShedule;
use App\Models\Setting\Parish;
use App\Models\Setting\ParishAlbum;
use App\Models\Person\Parishional;
use App\Models\Person\Priest;
use App\Models\Setting\ParishPatrimony;
use Illuminate\Http\Request;

class ParishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Parish::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $data = $req->except('photo');

        $this->validate($data, [
            'name' => 'required',
            'decision_creation' => 'required',
            'Pattern_date' => 'required',
            'nbr_of_structure' => 'required',
            'nbr_of_service' => 'required',
            'nbr_of_group' => 'required',
            'nbr_of_ceb' => 'required',
            'nbr_of_station' => 'required',
            'nbr_of_seminarist' => 'required'
         ]);

            $parish = new Parish();
            $parish->name = $data['name'];
            $parish->decision_creation = $data['decision_creation'];
            $parish->Pattern_date = $data['Pattern_date'];
            $parish->nbr_of_structure = $data['nbr_of_structure'];
            $parish->nbr_of_service = $data['nbr_of_service'];
            $parish->nbr_of_group = $data['nbr_of_group'];
            $parish->nbr_of_ceb = $data['nbr_of_ceb'];
            $parish->nbr_of_station = $data['nbr_of_station'];
            $parish->nbr_of_seminarist = $data['nbr_of_seminarist'];
            $parish->save();
       
        return response()->json($parish);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Person\Parish   $parish 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $parish = Parish::find($id);
        if (!$parish) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PARISH_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'name' => 'required',
            'decision_creation' => 'required',
            'Pattern_date' => 'required',
            'nbr_of_structure' => 'required',
            'nbr_of_service' => 'required',
            'nbr_of_group' => 'required',
            'nbr_of_ceb' => 'required',
            'nbr_of_station' => 'required',
            'nbr_of_seminarist' => 'required'
         ]);

        
         if ( $data['name'] ?? null) $parish->name = $data['name'];
         if ( $data['decision_creation'] ?? null) $parish->decision_creation = $data['decision_creation'];
         if ( $data['Pattern_date']?? null) $parish->Pattern_date = $data['Pattern_date'];
         if ( $data['nbr_of_structure'] ?? null) $parish->nbr_of_structure = $data['nbr_of_structure'];
         if ( $data['nbr_of_service'] ?? null) $parish->nbr_of_service = $data['nbr_of_service'];
         if ( $data['nbr_of_group'] ?? null) $parish->nbr_of_group = $data['nbr_of_group'];
         if ( $data['nbr_of_ceb'] ?? null) $parish->nbr_of_ceb = $data['nbr_of_ceb'];
         if ( $data['nbr_of_station'] ?? null) $parish->nbr_of_station = $data['nbr_of_station'];
         if ( $data['nbr_of_seminarist'] ?? null) $parish->nbr_of_seminarist = $data['nbr_of_seminarist'];
        
        $parish->update();

        return response()->json($parish);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person\Parish  $parish
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $parish = Parish::find($id);
        if (!$parish) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PARISH_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $parish->delete();      
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Parish::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        $parish = Parish::find($id);
        if (!$parish) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PARISH_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        //recuperation du nombre total de fidel
        $countparish = Parishional::select(Parishional::raw('count(*) as total'))->first();
        $nbreofparish = $countparish['total'];
        $albums = Photo::select('photos.*')
        ->join('albums', ['albums.id' => 'photos.album_id'])
        ->join('parish_albums', ['parish_albums.album_id' => 'albums.id'])
        ->join('parishs', ['parishs.id' => 'parish_albums.parish_id'])
        ->where('parishs.id', '=',$id)
        ->get();
        //on ajoute le chemin du backend
        foreach ($albums as $album) {
           $album->picture =  url($album->picture);
        }
        //recuperation du cure de la paroisse
        $priest = Priest::where('parish_id','=',$id)->get();
        //recuperation du patrimoine paroissiale
        $patrimonie = ParishPatrimony::where('parish_id','=',$id)->get();

        return response()->json([
            'parish' => [
                'name' =>  $parish->name,
                'logo' =>  $parish->logo,
                'nb_paroissien' =>  $nbreofparish,
                'decision_creation' => $parish->decision_creation,
                'nb_structure'   => $parish->nbr_of_structure,
                'nb_service' => $parish->nbr_of_service,
                'nb_group' => $parish->nbr_of_group,
                'nb_ceb' => $parish->nbr_of_ceb,
                'nb_station' => $parish->nbr_of_station,
                'nb_seminariste' => $parish->nbr_of_seminarist,
            ],
            'priest' => $priest,
            'photos' => $albums,
            'patrimonies' => $patrimonie
        ]);



    }

    public function findParishAlbum(Request $req, $id)
    {
        if (!$album = Album::whereParishId($id)->simplePaginate($req->has('limit') ? $req->limit : 15)) {
            abort(404, "No album for category with id $id found ");
        }
        return response()->json($album);
    }
    
    public function findmassSchedules(Request $req, $id)
    {
        if (!$masschedule = MassShedule::whereParishId($id)->simplePaginate($req->has('limit') ? $req->limit : 15)) {
            abort(404, "No masschedule for category with id $id found ");
        }
        return response()->json($masschedule);
    }
    public function findParishPatrimonies(Request $req, $id)
    {
        if (!$parishpatrimony = ParishPatrimony::whereParishId($id)->simplePaginate($req->has('limit') ? $req->limit : 15)) {
            abort(404, "No parishpatrimony for category with id $id found ");
        }
        return response()->json($parishpatrimony);
    }
    public function findContacts(Request $req, $id)
    {
        if (!$contact = Contact::whereParishId($id)->simplePaginate($req->has('limit') ? $req->limit : 15)) {
            abort(404, "No contact for category with id $id found ");
        }
        return response()->json($contact);
    }

}
