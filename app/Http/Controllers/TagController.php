<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
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
     * Store a newly created resource in storage.
     */
    public function store(TagRequest $request)
    {
        try {
            $tag = Tag::create( $request->all() );
            return $this->successResponse( new TagResource( $tag ),'Tag created successfully' );
        }catch ( \Exception $e ){
            return $this->errorResponse($e->getMessage(), 409);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TagRequest $request, Tag $tag)
    {
        try {
            $tag->update( $request->all() );
            return $this->successResponse( new TagResource( $tag ),'Tag updated successfully' );
        }catch ( \Exception $e ){
            return $this->errorResponse($e->getMessage(), 409);
        }
    }


}
