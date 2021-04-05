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
        return GroupcodeResource::collection(Groupcode::where('company_id', Auth::guard('admin')->user()->company_id)
                                                        ->orWhereNull('company_id')
                                                        ->latest()->get());
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

        $company_id = ['company_id' => Auth::guard('admin')->user()->company_id];
       $request->merge($company_id);

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

        $company_id = ['company_id' => Auth::guard('admin')->user()->company_id];
        $request->merge($company_id);

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
