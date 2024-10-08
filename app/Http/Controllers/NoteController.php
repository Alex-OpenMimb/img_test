<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use App\Http\Resources\NoteResource;
use App\Http\Resources\TagResource;
use App\Models\Note;
use App\Services\NoteService;
use App\Traits\ApiResponser;
use Carbon\Carbon;
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
            $notes = Note::get();
            return $this->successResponse( NoteResource::collection( $notes ) );

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
     * Update the specified resource in storage.
     */
    public function update(NoteRequest $request, Note $note)
    {
        try {
            $note->update( [
                'title'           => $request['title'],
                'description'     => $request['description'],
                'expiration_date' => $request['expiration_date'],
                'tag_id'          => $request['tag_id'],
            ] );
            if(  $request['image']  ){
                //Delete the image if it exists to update it
                if( $note->image ){
                    if( Storage::disk('public')->exists($note->image) ) Storage::disk('public')->delete( $note->image);
                }
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
            //Delete the image if it exists to update it
            if( $note->image ){
                if( Storage::disk('public')->exists($note->image) ) Storage::disk('public')->delete( $note->image);
            }
           return $this->showMessage('Note destroyed successfully');
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage(), 409);
        }
    }

    /**
     * Build data to store
     */
    protected function buildData( $request )
    {
        $user_id       = auth()->user()->id;
        $creation_date =  Carbon::now()->format('Y-m-d');
       return    [
            'title'           => $request['title'],
            'description'     => $request['description'],
            'creation_date'   => $creation_date,
            'expiration_date' => $request['expiration_date'],
            'user_id'         => $user_id,
            'tag_id'          => $request['tag_id'],
        ];
    }

    /**
     * Store image
     */
    protected function storeImage(  $note, $request )
    {
        $image_path = NoteService::storeImage($note, $request['image']);
        $note->image = $image_path;
        $note->save();
    }


    /**
     * Order by creation or expiration date
     */
    protected function orderByDate(Request $request)
    {
        try {
            $order = $request->query('order');
            $date = $request->query('date');
            $notes = Note::orderBy($date,$order)->get();
            return $this->successResponse( NoteResource::collection( $notes ) );
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage(), 409);
        }
    }

}
