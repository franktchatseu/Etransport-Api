<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Finance\PatternDonation;
use App\Models\APIError;

class PatternDonationController extends Controller
{
  
        public function store(Request $request){
    
            $this->validate($request->all(), [
                'name' => 'required|string|unique:pattern_donations',
            ]);
    
            $patterndonation = PatternDonation::create([
                'name' => $request->name,
                'description' => $request->description
            ]);
    
    
            return response()->json($patterndonation);
        }
    
        public function update(Request $request, $id){
    
            $patterndonation = PatternDonation::find($id);
            if($patterndonation == null) {
                $notFoundError = new APIError;
                $notFoundError->setStatus("404");
                $notFoundError->setCode("PATTERN_NOT_FOUND");
                $notFoundError->setMessage("PatternDonation type with id " . $id . " not found");
                return response()->json($notFoundError, 404);
            }
    
            $this->validate($request->all(), [
                'name' => 'required|string',
            ]);
    
            $role_tmp = PatternDonation::whereName($request->name)->first();
    
            if($role_tmp != null && $role_tmp != $patterndonation) {
                $notFoundError = new APIError;
                $notFoundError->setStatus("400");
                $notFoundError->setCode("ROLE_ALREADY_EXISTS");
                $notFoundError->setMessage("PatternDonation aleady exists");
                return response()->json($notFoundError, 400);
            }
    
            $role_tmp = PatternDonation::whereName($request->display_name)->first();
    
            $patterndonation->update([
                'name' => $request->name,
                'description' => $request->description
            ]);
    
            return response()->json($patterndonation);
        }
    
        public function delete($id) {
            $patterndonation = PatternDonation::find($id);
            if($patterndonation == null) {
                $notFoundError = new APIError;
                $notFoundError->setStatus("404");
                $notFoundError->setCode("PATTERN_NOT_FOUND");
                $notFoundError->setMessage("PatternDonation type with id " . $id . " not found");
                return response()->json($notFoundError, 404);
            }
            PatternDonation::find($id)->delete();
            return response()->json(null);
        }
    
        public function get(Request $request){
            $limit = $request->limit;
            $s = $request->s;
            $page = $request->page;
            $patterndonations = PatternDonation::where('name', 'LIKE', '%'.$s.'%')
                                      ->paginate($limit);
            return response()->json($patterndonations);
        }
    
    
    
        public function find($id){
            $patterndonation = PatternDonation::find($id);
            if($patterndonation == null) {
                $notFoundError = new APIError;
                $notFoundError->setStatus("404");
                $notFoundError->setCode("PATTERN_NOT_FOUND");
                $notFoundError->setMessage("Assignment type with id " . $id . " not found");
                return response()->json($notFoundError, 404);
            }
            $patterndonation->permissions;
            return response()->json($patterndonation);
        }
    
    
}
