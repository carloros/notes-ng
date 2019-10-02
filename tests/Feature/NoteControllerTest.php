<?php

namespace Tests\Feature;

use App\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * Class NoteControllerTest
 *
 * @package Tests\Feature
 * @covers
 */
class NoteControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function shows_no_notes_at_init_state()
    {
        $this->withoutExceptionHandling();
        // 1 Prepare skip

        // 2 Execute
        $response = $this->json('GET', '/api/v1/notes');

        // 3 Assert
        $response->assertSuccessful();

        $notesJson = $response->getContent();
        $notes = json_decode($notesJson);

        $response->assertJson([]);
        $response->assertJsonCount(0);
        $this->assertEquals($notesJson, "[]");
    }

    /**
     * @test
     */
    public function shows_notes_ok()
    {
        // 1 Prepare -> Seed database with

        //Models
        Note::create([
            'name' => '2DAM',
        ]);

        Note::create([
            'name' => '2ASIX',
        ]);

        Note::create([
            'name' => '2ASIX2',
        ]);

        // 2 Execute
        $response = $this->json('GET', '/api/v1/notes');

        // 3 Assert
        $response->assertSuccessful();

        $notesJson = $response->getContent();
        $notes = json_decode($notesJson);
        //$response->assertExactJson([
        //    "name" => "SMX"
        //]);
        $response->assertJsonCount(3);
        $this->assertEquals($notes[0]->name, "2DAM");
        $this->assertEquals($notes[1]->name, "2ASIX");
        $this->assertEquals($notes[2]->name, "2ASIX2");
    }
}
