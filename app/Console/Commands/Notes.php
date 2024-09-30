<?php

namespace App\Console\Commands;

use App\Models\Note;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class Notes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notes {--title=} {--description=} {--creation_date=} {--expiration_date=?} {--user=} {--tag=}';


    protected $user_id;
    protected $tag_id;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to create notes';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        try {
            //Validate options
            if( !self::validateOptions() ) return $this->error('Check the options passed');
            if( self::validateUniqueTitle() ) return $this->error('Error: The title already exists');
            $this->user_id = self::findUserId();
            $this->tag_id = self::findTagId();
            if( !$this->user_id ) return $this->error('Error: The user dosent exist');
            if( !$this->tag_id ) return $this->error('Error: the tag dosent exist');

            //Validate Date
            $errorMessage = 'Error: The date is not in the correct format Y-m-d.';
            $creationDate = self::validateFormatDate( $this->option('creation_date') );
            if( !$creationDate ) return $this->error( $errorMessage );
            $expirationDate = self::validateFormatDate( $this->option('expiration_date') );
            if( !$expirationDate )  return $this->error( $errorMessage );
            if( !$expirationDate->greaterThan( $creationDate ) ) return  $this->error('Error: The expiration date must  be later than creation date');

            Note::create([
                'title'           => $this->option('title'),
                'description'     => $this->option('description'),
                'creation_date'   => $creationDate->format('Y-m-d'),
                'expiration_date' => $expirationDate->format('Y-m-d'),
                'user_id'         => $this->user_id->id,
                'tag_id'          => $this->tag_id->id,
            ]);

            $this->info('Note created successfully');
        }catch (\Exception $e){
            $this->error($e->getMessage());
        }



    }


    protected function validateOptions()
    {
        $validator = true;
        $message = 'Error: Options missing';
        if( !$this->option('title') ){
            $validator = false;
            $this->error($message .' --title.');

        }elseif( !$this->option('description') ){
            $validator = false;
            $this->error(  $message .' --description.');

        }elseif( !$this->option('creation_date') ){
            $validator = false;
            $this->error( $message .' --creation_date.');

        }elseif( !$this->option('user') ){
            $validator = false;
            $this->error($message.' --user.');

        }elseif( !$this->option('tag') ){
            $validator = false;
            $this->error( $message. '--tag.');

        }

        return $validator;

    }


    protected function findUserId()
    {
        return User::where('name', $this->option('user') )->select('id')->first();
    }


    protected function findTagId()
    {
        return Tag::where('name', $this->option('tag') )->select('id')->first();
    }

    protected function validateUniqueTitle()
    {
        return Note::where('title', $this->option('title'))->get()->count();
    }


    protected function validateFormatDate( $dateIncoming )
    {
         $date = Carbon::createFromFormat('Y-m-d', $dateIncoming );
        if ($date && $date->format('Y-m-d') === $dateIncoming ) {
            return $date;
        } else {
            return false;

        }
    }
}
