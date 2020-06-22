<?php

namespace App\Http\Controllers\Association;

use App\Http\Controllers\Controller;
use App\Models\Association\EventPresenceMemberAssociation;
use Illuminate\Http\Request;
use App\Models\APIError;

class EventPresenceMemberAssociationController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function index (Request $req)
    {
        $data = EventPresenceMemberAssociation::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
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
            'evenement_id' => 'required',
            'member_association_id' => 'required',
            'isPresence' => 'required',
        ]);

            $eventmemberAssociation = new EventPresenceMemberAssociation();
            $eventmemberAssociation->evenement_id = $data['evenement_id'];
            $eventmemberAssociation->member_association_id = $data['member_association_id'];
            $eventmemberAssociation->isPresence = $data['isPresence'];
            $eventmemberAssociation->save();
       
        return response()->json($eventmemberAssociation);
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
        $eventmemberAssociation = EventPresenceMemberAssociation::find($id);
        if (!$eventmemberAssociation) {
            $apiError = new APIError;
            $apiError->setmember_association_id("404");
            $apiError->setCode("EVENTMEMBERASSOCIATION_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'evenement_id' => 'required',
            'member_association_id' => 'required',
            'isPresence' => 'required',

        ]);

        if (null !== $data['evenement_id']) $eventmemberAssociation->evenement_id = $data['evenement_id'];
        if (null !== $data['member_association_id']) $eventmemberAssociation->member_association_id = $data['member_association_id'];
        if (null !== $data['isPresence']) $eventmemberAssociation->isPresence = $data['isPresence'];

        $eventmemberAssociation->update();

        return response()->json($eventmemberAssociation);
    }

    /**
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $eventmemberAssociation = EventPresenceMemberAssociation::find($id);
        if (!$eventmemberAssociation) {
            $apiError = new APIError;
            $apiError->setmember_association_id("404");
            $apiError->setCode("EVENTMEMBERASSOCIATION_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $eventmemberAssociation->delete();      
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

        $data = EventPresenceMemberAssociation::where($req->field, 'like', "%$req->q%")
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
        $eventmemberAssociation = EventPresenceMemberAssociation::find($id);
        if (!$eventmemberAssociation) {
            $apiError = new APIError;
            $apiError->setmember_association_id("404");
            $apiError->setCode("EVENTMEMBERASSOCIATION_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($eventmemberAssociation);
    }
    public function findPresence(Request $req, $id)
    {
        $event = EventPresenceMemberAssociation::select('event_presence_member_associations.*','event_presence_member_associations.id as event_presence_member_association_id','evenements.*')
        ->join('evenements', 'event_presence_member_associations.evenement_id', '=', 'evenements.id' )
        ->where(['event_presence_member_associations.member_association_id' => $id])
        ->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($event);
    }
     
 
}
