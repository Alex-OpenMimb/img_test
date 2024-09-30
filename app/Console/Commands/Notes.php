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
    //protected $signature = 'app:notes {--tag=} ';

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
        //Validate options
         if( !self::validateOptions() ) return $this->error('Check the options passed');
         $this->user_id = self::findUserId();
         $this->tag_id = self::findTagId();
         if( !$this->user_id ) return $this->error('User dosent exist');
         if( !$this->tag_id ) return $this->error('tag dosent exist');

          $creationDate = Carbon::parse($this->option('creation_date'));
          $expirationDate = Carbon::parse($this->option('expiration_date'));

         Note::create([
             'title'           => $this->option('title'),
             'description'     => $this->option('description'),
             'creation_date'   => $creationDate,
             'expiration_date' => $expirationDate,
             'user_id'         => $this->user_id->id,
             'tag_id'          => $this->tag_id->id,
         ]);

         $this->info('Note created successfully');


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
}
