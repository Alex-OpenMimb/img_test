<?php

namespace Tests\Unit;

use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;


class NoteControllerTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_can_get_all_notes()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $tag = Tag::factory()->create();
         $note = Note::factory()->create([
            'title'           => 'Futbol',
            'description'     => 'Inicio del mundial',
            'creation_date'   =>  Carbon::now()->format('Y-m-d'),
            'expiration_date' =>  Carbon::now()->addDay(3)->format('Y-m-d'),
            'user_id'         => $user->id,
            'tag_id'          => $tag->id
        ]);

        $response = $this->getJson('/api/notes');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJson([
                'message' => null,
                'response' => true,
                'code' => 200,
                'data' => [
                    [
                        'id' => $note->id,
                        'title' => 'Futbol',
                        'description' => 'Inicio del mundial',
                        'image'     => null,
                        'creation_date' => $note->creation_date,
                        'expiration_date' => $note->expiration_date,
                    ]
                ]
            ]);
    }
    /** @test */
    public function it_can_create_a_note()
    {

        $user = User::factory()->create();
        $this->actingAs($user);
        $tag = Tag::factory()->create();
        $response = $this->postJson('/api/notes', [
            'title'           => 'Futbol',
            'description'     => 'Inicio del mundial',
            'creation_date'   =>  Carbon::now()->format('Y-m-d'),
            'expiration_date' =>  Carbon::now()->addDay(3)->format('Y-m-d'),
            'user_id'         => $user->id,
            'tag_id'          => $tag->id,
        ]);
        $noteId = $response->json('data.id');
            $response->assertStatus(200)
                ->assertJson([
                    'data' => [
                        'id'              => $noteId,
                        'title'           => 'Futbol',
                        'image'           => null,
                        'description'     => 'Inicio del mundial',
                        'creation_date'   => Carbon::now()->format('Y-m-d'),
                        'expiration_date' => Carbon::now()->addDay(3)->format('Y-m-d'),
                        'user'            => $user->name,
                        'tag'             => $tag->name,
                        'tag_id'          => $tag->id,
                    ],
                    'message' => 'Note created successfully',
                    'response' => true,
                    'code' => 200,
                ]);

        $this->assertCount(1, Note::all());
    }


    /** @test */
    public function it_can_update_a_note()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $tag = Tag::factory()->create();
        $note = Note::factory()->create([
            'title'           => 'Futbol',
            'description'     => 'Inicio del mundial',
            'creation_date'   => Carbon::now()->format('Y-m-d'),
            'expiration_date' => Carbon::now()->addDay(3)->format('Y-m-d'),
            'user_id'         => $user->id,
            'tag_id'          => $tag->id,
        ]);


        $response = $this->putJson("/api/notes/{$note->id}", [
            'title'           => 'Atletismo',
            'description'     => 'Final del mundial',
            'expiration_date' => Carbon::now()->addDay(5)->format('Y-m-d'),
            'user_id'         => $user->id,
            'tag_id'          => $tag->id,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id'              => $note->id,
                    'title'           => 'Atletismo',
                    'description'     => 'Final del mundial',
                    'creation_date'   => Carbon::now()->format('Y-m-d'),
                    'expiration_date' => Carbon::now()->addDay(5)->format('Y-m-d'),
                    'user'            => $user->name,
                    'tag'             => $tag->name,
                    'tag_id'          => $tag->id,
                ],
                'message' => 'Note updated successfully',
                'response' => true,
                'code' => 200,
            ]);

        $this->assertEquals('Atletismo', Note::find($note->id)->title);
    }


    /** @test */
    public function it_can_delete_a_note()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $tag = Tag::factory()->create();
        $note = Note::factory()->create([
            'title'           => 'Futbol',
            'description'     => 'Inicio del mundial',
            'creation_date'   => Carbon::now()->format('Y-m-d'),
            'expiration_date' => Carbon::now()->addDay(3)->format('Y-m-d'),
            'user_id'         => $user->id,
            'tag_id'          => $tag->id,
        ]);


        $response = $this->deleteJson("/api/notes/{$note->id}");

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Note destroyed successfully',
                'response' => true,
                'code' => 200,
            ]);

        $this->assertNull(Note::find($note->id));
    }




}
