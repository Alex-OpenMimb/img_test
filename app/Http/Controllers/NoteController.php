<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use App\Services\NoteService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class NoteController extends Controller
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
        try{
            $note = Note::get();
            return $this->successResponse( NoteResource::collection( $note ) );

        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage(), 409);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NoteRequest $request)
    {
        try {
            $note = Note::create( [
                'title'           => $request['title'],
                'description'     => $request['description'],
                'creation_date'   => $request['creation_date'],
                'expiration_date' => $request['expiration_date'],
                'user_id'         => $request['user_id'],
                'tag_id'          => $request['tag_id'],
            ] );

            $image_path = NoteService::storeImage($note, $request['image']);
            $note->image = $image_path;
            $note->save();

            return $this->successResponse( new NoteResource( $note ),'Note created successfully' );

        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage(), 409);
        }
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
