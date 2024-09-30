<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use App\Http\Resources\NoteResource;
use App\Http\Resources\TagResource;
use App\Models\Note;
use App\Services\NoteService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            $data = self::buildData( $request );
            $note = Note::create( $data );
            if(  $request['image']  ){
                self::storeImage( $note, $request );
            }
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
    public function update(NoteRequest $request, Note $note)
    {

        try {
            $data = self::buildData( $request );
            $note->update( $data );
            if(  $request['image']  ){
                if( Storage::exists($note->image) ) Storage::disk('public')->delete( $note->image);
               self::storeImage( $note, $request );
            }
          return  $this->successResponse( new NoteResource( $note ), 'Note updated successfully' );
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage(), 409);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        try{
            $note->delete();
            return $this->showMessage('Note destroyed successfully');
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage(), 409);
        }
    }


    protected function buildData( $request )
    {
       return    [
            'title'           => $request['title'],
            'description'     => $request['description'],
            'creation_date'   => $request['creation_date'],
            'expiration_date' => $request['expiration_date'],
            'user_id'         => $request['user_id'],
            'tag_id'          => $request['tag_id'],
        ];
    }

    protected function storeImage(  $note, $request )
    {
        $image_path = NoteService::storeImage($note, $request['image']);
        $note->image = $image_path;
        $note->save();
    }

}
