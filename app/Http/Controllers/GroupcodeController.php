<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GroupcodeRequest;
use App\Groupcode;
use App\Http\Resources\GroupcodeResource;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class GroupcodeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return GroupcodeResource::collection(Groupcode::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupcodeRequest $request)
    {
        $created_by = ['created_by' => Auth::guard('admin')->user()->id];
        $request->merge($created_by);
        $groupcode = new Groupcode($request->all());
        $groupcode->save();

        return response(['name' => $groupcode->name], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Groupcode  $groupcode
     * @return \Illuminate\Http\Response
     */
    public function show(Groupcode $groupcode)
    {
       return new GroupcodeResource($groupcode);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Groupcode  $groupcode
     * @return \Illuminate\Http\Response
     */
    public function update(GroupcodeRequest $request, Groupcode $groupcode)
    {
        $created_by = ['created_by' => Auth::guard('admin')->user()->id];
        $request->merge($created_by);
        $groupcode->update($request->all());
        return response(['name' => $groupcode->name], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Groupcode  $groupcode
     * @return \Illuminate\Http\Response
     */
    public function destroy(Groupcode $groupcode)
    {
       $groupcode->delete();
       return response(null, Response::HTTP_NO_CONTENT);
    }
}
