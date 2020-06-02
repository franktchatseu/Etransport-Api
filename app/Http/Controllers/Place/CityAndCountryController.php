<?php

namespace App\Http\Controllers\Place;

use App\Models\Place\City;
use Illuminate\Http\Request;
use App\Models\Place\Country;
use App\Http\Controllers\Controller;

class CityAndCountryController extends Controller
{
    public function countries() {
        $cities = City::get();
        return response()->json($cities);
    }

    public function searchCountries(Request $req) {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Country::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function searchCities(Request $req) {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = City::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function findCitiesByCountries($id) {
       
        $cities = City::whereCountryId($id)->get();
        return response()->json($cities);
    }

    public function cities() {
        $cities = City::get();
        return response()->json($cities);
    }
}
