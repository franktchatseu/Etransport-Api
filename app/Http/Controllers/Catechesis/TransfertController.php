<?php

namespace App\Http\Controllers\Catechesis;

use App\Http\Controllers\Controller;
use App\Models\Catechesis\Transfert;
use Illuminate\Http\Request;

class TransfertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    { 
        {
            $data = Transfert::simplePaginate($req->has('limit') ? $req->limit : 15);
            return response()->json($data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $data = $request->only([
            'motif',
            'date',
            'documents',
            'status',

        ]);

        $this->validate($data, [
            'motif' => 'required',
            'date' => 'required',
            'documents' => 'required',
            'status' => 'in:REJECTED,PENDING,ACCEPTED',
        ]);

        $documentsPaths = $this->uploadMultipleFiles($request, 'documents', 'transferts', ['file', 'mimes:pdf,doc,ppt,xls,rtf,jpg,png']);
        $data['documents'] = json_encode($documentsPaths);

        $transfert = new Transfert();
        $transfert->motif = $data['motif'];
        $transfert->date = $data['date'];
        $transfert->documents = $data['documents'];
        $transfert->status = $data['status'];

        $transfert->save();

        return response()->json($transfert);
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Transfert::where($req->field, 'like', "%$req->q%")->get();

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Catechesis\Transfert  $transfert
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $transfert = Transfert::find($id);
        if (!$transfert) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("TRANSFERT_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($transfert);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catechesis\Transfert  $transfert
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $transfert = Transfert::find($id);
        if (!$transfert) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("TRANSFERT_NOT_FOUND");
            return response()->json($apiError, 404);
        }


        $data = $request->only([
            'motif',
            'date',
            'documents',
            'status'
        ]);

        $this->validate($data, [
            'motif' => 'required',
            'date' => 'required',
            'documents' => 'required',
            'status' => 'in:Rejected,Painding,Accepted',
        ]);

        //upload document
        $documentPaths = $this->uploadMultipleFiles($request, 'documents', 'transferts', ['file', 'mimes:pdf,doc,ppt,xls,rtf,jpg,png']);
        $data['documents'] = json_encode($documentPaths);

        if (null !== $data['motif']) {
            $transfert->motif = $data['motif'];
        }
        if (null !== $data['date']) {
            $transfert->date = $data['date'];
        }
        if (null !== $data['documents']) {
            $transfert->documents = $data['documents'];
        }
        if (null !== $data['status']) {
            $transfert->status = $data['status'];
        }

        $transfert->update();

        return response()->json($transfert);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Catechesis\Transfert  $transfert
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transfert = Transfert::find($id);
        if (!$transfert) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("TRANSFERT_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $transfert->delete();
        return response()->json();
    }
}
