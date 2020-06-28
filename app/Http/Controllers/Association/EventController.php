<?php

namespace App\Http\Controllers\Association;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Association\Event;

class EventController extends Controller
{
     //
     public function store(Request $req){
        $data = $req->only([
            'name',
            'description'
        ]);

        $this->validate($data, [
            'name' => 'required'
        ]);

        
        $event = new Event();
        $event->name = $data['name'];
        $event->description = $data['description'];
        $event->save();
       
        return response()->json($event);
    }


    public function update(Request $req, $id)
    {
        $event = Event::find($id);
        if (!$event) {
            abort(404, "No event$event found with id $id");
        }

        $data = $req->only([
            'name',
            'description'
        ]);

        $this->validate($data, [
            'name' => 'required'
        ]);

        if (null !== $data['name']) $event->name = $data['name'];
        if (null !== $data['description']) $event->description = $data['description'];
       
        $event->update();
        return response()->json($event);
    }


    public function destroy($id)
    {
        if (!$event = Event::find($id)) {
            abort(404, "No event$event found with id $id");
        }

        $event->delete();      
        return response()->json();
    }


    public function find($id)
    {
        if (!$event = Event::find($id)) {
            abort(404, "No event$event found with id $id");
        }
        return response()->json($event);
    }

    public function index(Request $req)
    {
        $data = Event::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',// on cherche q dans la table sur le champ field
            'field' => 'present'
        ]);

        $data = Event::where($req->field, 'like', "%$req->q%")
            ->get();

        return response()->json($data);
    }
}
