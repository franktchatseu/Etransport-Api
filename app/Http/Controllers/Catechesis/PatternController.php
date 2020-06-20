<?php
namespace App\Http\Controllers\Catechesis;

use App\Http\Controllers\Controller;
use App\Models\Catechesis\Pattern;
use Illuminate\Http\Request;

class PatternController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function index (Request $req)
    {
        $data = Pattern::simplePaginate($req->has('limit') ? $req->limit : 15);
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
            'reason' => 'required',
            'description' => 'required'
        ]);

            $pattern = new Pattern();
            $pattern->reason = $data['reason'];
            $pattern->description = $data['description'];
            $pattern->save();
       
        return response()->json($pattern);
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
        $pattern = Pattern::find($id);
        if (!$pattern) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PATTERN_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'reason' => 'required',
            'description' => 'required'
        ]);

        if ( $data['reason']) $pattern->reason = $data['reason'];
        if ( $data['description']) $pattern->description = $data['description'];
        
        $pattern->update();

        return response()->json($pattern);
    }

    /**
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pattern = Pattern::find($id);
        if (!$pattern) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PATTERN_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $pattern->delete();      
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

        $data = Pattern::where($req->field, 'like', "%$req->q%")
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
        $pattern = Pattern::find($id);
        if (!$pattern) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PATTERN_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($pattern);
    }
}
