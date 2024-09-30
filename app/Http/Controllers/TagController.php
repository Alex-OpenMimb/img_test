<?php

namespace App\Http\Controllers;

use App\Http\Resources\TagResource;
use App\Traits\ApiResponser;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{

    use ApiResponser;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $tags = Tag::get();
            return $this->successResponse( TagResource::collection($tags) );
        }catch ( \Exception $e ){
            return $this->errorResponse($e->getMessage(), 409);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $tags = Tag::get();
            return $this->successResponse( TagResource::collection($tags) );
        }catch ( \Exception $e ){
            return $this->errorResponse($e->getMessage(), 409);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
