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
use App\Models\Setting\Programme;
use Illuminate\Http\Request;
use App\Models\Extra\Group;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



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
            'email' => 'required',
            'phone' => 'required',
            'description' => 'required',
            'name_priest' => 'required',
            'picture_priest' => 'required',
            'nbr_of_structure' => 'required',
            'nbr_of_service' => 'required',
            'nbr_of_group' => 'required',
            'nbr_of_ceb' => 'required',
            'nbr_of_station' => 'required',
            'nbr_of_seminarist' => 'required'
         ]);


            $parish = new Parish();
            $parish->name = $data['name'];
            $parish->description = $data['description'];
            $parish->phone = $data['phone'];
            $parish->email = $data['email'];
            $parish->name_priest = $data['name_priest'];
            $parish->decision_creation = "decison of creation";
            //$parish->Pattern_date = Carbon::now();
            $parish->nbr_of_structure = $data['nbr_of_structure'];
            $parish->nbr_of_service = $data['nbr_of_service'];
            $parish->nbr_of_group = $data['nbr_of_group'];
            $parish->nbr_of_ceb = $data['nbr_of_ceb'];
            $parish->nbr_of_station = $data['nbr_of_station'];
            $parish->nbr_of_seminarist = $data['nbr_of_seminarist'];
            $path = null;
            $path1 = null;
               //recuperation et sauvegarde des images
         if(isset($req->logo) && isset($req->picture_priest)){
            $logo = $req->file('logo');
            $picture_priest = $req->file('picture_priest');
           
            if($logo != null){
                $extension = $logo->getClientOriginalExtension();
                $relativeDestination = "uploads/Parish";
                $destinationPath = public_path($relativeDestination);
                $safeName = "parish".time().'.'.$extension;
                $logo->move($destinationPath, $safeName);
                $path1 = url("$relativeDestination/$safeName");
                
            }
            if($picture_priest != null){
                $extension = $picture_priest->getClientOriginalExtension();
                $relativeDestination = "uploads/Parish";
                $destinationPath = public_path($relativeDestination);
                $safeName = "picture_priest".time().'.'.$extension;
                $picture_priest->move($destinationPath, $safeName);
                $path2 = url("$relativeDestination/$safeName");
            }
             
           
        }
        $parish->logo = $path1;
        $parish->picture_priest =$path2;

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

        $this->validate($data, [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'description' => 'required',
            'name_priest' => 'required',
            'nbr_of_structure' => 'required',
            'nbr_of_service' => 'required',
            'nbr_of_group' => 'required',
            'nbr_of_ceb' => 'required',
            'nbr_of_station' => 'required',
            'nbr_of_seminarist' => 'required'
         ]);

        
         if ( $data['name'] ?? null) $parish->name = $data['name'];
         if ( $data['email'] ?? null) $parish->email = $data['email'];
         if ( $data['phone'] ?? null) $parish->phone = $data['phone'];
         if ( $data['description'] ?? null) $parish->description = $data['description'];
         if ( $data['name_priest'] ?? null) $parish->name_priest = $data['name_priest'];
         if ( $data['decision_creation'] ?? null) $parish->decision_creation = $data['decision_creation'];
         if ( $data['Pattern_date']?? null) $parish->Pattern_date = $data['Pattern_date'];
         if ( $data['nbr_of_structure'] ?? null) $parish->nbr_of_structure = $data['nbr_of_structure'];
         if ( $data['nbr_of_service'] ?? null) $parish->nbr_of_service = $data['nbr_of_service'];
         if ( $data['nbr_of_group'] ?? null) $parish->nbr_of_group = $data['nbr_of_group'];
         if ( $data['nbr_of_ceb'] ?? null) $parish->nbr_of_ceb = $data['nbr_of_ceb'];
         if ( $data['nbr_of_station'] ?? null) $parish->nbr_of_station = $data['nbr_of_station'];
         if ( $data['nbr_of_seminarist'] ?? null) $parish->nbr_of_seminarist = $data['nbr_of_seminarist'];
         //recuperation et sauvegarde des images
         if(isset($req->logo)&& issset($req->picture_priest)){
            $logo = $req->file('logo');
            $path = null;
            if($logo != null){
                $extension = $file->getClientOriginalExtension();
                $relativeDestination = "uploads/Parish";
                $destinationPath = public_path($relativeDestination);
                $safeName = "parish".time().'.'.$extension;
                $logo->move($destinationPath, $safeName);
                $path = url("$relativeDestination/$safeName");
            }
            if($picture_priest != null){
                $extension = $file->getClientOriginalExtension();
                $relativeDestination = "uploads/Parish";
                $destinationPath = public_path($relativeDestination);
                $safeName = "picture_priest".time().'.'.$extension;
                $picture_priest->move($destinationPath, $safeName);
                $path = url("$relativeDestination/$safeName");
            }
            $data['logo'] = $path;
            $data['picture_priest'] = $path;
            

        }
        
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
        
        return response()->json($parish); 
    }

   
    public function findWithAlbum(Request $req, $id)
    {
         $parish = Parish::find($id); 
        //return response()->json($parish->name);
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
        $priest = Priest::where('parish_id','=',$id)->first();
        //recuperation du patrimoine paroissiale
        $patrimonie = ParishPatrimony::where('parish_id','=',$id)->get();

        return response()->json([
            'parish' => [
                'name' =>  $parish->name,
                'logo' =>  url($parish->logo),
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

     
    public function parishPresentation(Request $req, $id)
    {
         $parish = Parish::find($id); 
        //return response()->json($parish->name);
        if (!$parish) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PARISH_NOT_FOUND");
            return response()->json($apiError, 404);
        }

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
        //recuperation du programme des messes
        $now_date =  Carbon::now();
        $hebdo_date =Carbon::now()->subDays(7);

        $programmes = Programme::select('programmes.*')
        ->whereBetween('created_at', array($hebdo_date, $now_date))
        ->where('programmes.parish_id',$id)->get();

        return response()->json([
            'parish' => [
                'parish_id' => $parish->id,
                'description' => $parish->description,
                'email' => $parish->email,
                'phone' => $parish->phone,
                'photos' => $albums,
            ],

            'programmes' => $programmes,
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

    public function findGroupbyType(Request $req, $id)
    {
        $parish = Parish::find($id);
        if (!$parish) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        //$groups = Group::whereParishId($id)->simplePaginate($req->has('limit') ? $req->limit : 15);
        
        $groups= Group::select('groups.*',
                                'grouptypes.id as grouptype_id'
                                )
        ->join('grouptypes','groups.grouptypes_id','=','grouptypes.id')
        //->join('grouptypes','groups.grouptypes_id','=','grouptypes.id')
        ->where(['groups.parishs_id' =>$id])
        ->simplePaginate($req->has('limit') ? $req->limit : 15);

        /*$groups = DB::table('groups')
                ->join('grouptypes','grouptypes.id','=','groups.grouptypes_id')
                ->join('parishs','parishs.id','=','groups.parishs_id')
                ->select('groups.*','parishs.name as parish','grouptypes.nom as grouptypes')
                ->where('groups.parishs_id','=',$id)
                ->simplePaginate($req->has('limit') ? $req->limit : 15);*/
      
        return response()->json($groups);
    }

   

}
