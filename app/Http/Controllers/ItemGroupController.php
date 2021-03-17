<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ItemGroup;
use App\Http\Resources\ItemGroupResource;
class ItemGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return ItemGroupResource::collection(ItemGroup::where('status_id', 1)->get());
    }
}
