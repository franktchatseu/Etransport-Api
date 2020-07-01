<?php

namespace App\Http\Controllers;

use App\Models\Notification\UserParishionalMessage;
use Illuminate\Http\Request;

class UserParishionalMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = UserParishionalMessage::simplePaginate($req->has('limit') ? $req->limit : 15);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification\UserParishionalMessage  $userParishionalMessage
     * @return \Illuminate\Http\Response
     */
    public function show(UserParishionalMessage $userParishionalMessage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification\UserParishionalMessage  $userParishionalMessage
     * @return \Illuminate\Http\Response
     */
    public function edit(UserParishionalMessage $userParishionalMessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification\UserParishionalMessage  $userParishionalMessage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserParishionalMessage $userParishionalMessage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification\UserParishionalMessage  $userParishionalMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserParishionalMessage $userParishionalMessage)
    {
        //
    }
}
