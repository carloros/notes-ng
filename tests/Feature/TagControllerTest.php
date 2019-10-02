<?php

namespace Tests\Feature;

use App\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * Class TagControllerTest
 *
 * @package Tests\Feature
 * @covers
 */
class TagControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function shows_no_tags_init_state()
    {
        $this->withoutExceptionHandling();

        //    Prepare -> Skipping

        //    Execute
        $response = $this->json('GET', '/api/v1/tags');

        //    Assert
        $response->assertSuccessful();

        $tagsJson = $response->getContent();
        $tags = json_decode($tagsJson);

        //    Checking return in JSON
        $response->assertJson([]);
        $response->assertJsonCount(0);
        $this->assertEquals($tagsJson, "[]");
    }

    /**
     * @test
     */
    public function shows_tags_ok()
    {
        //    Prepare -> Seed database with...

        //    Models
        Tag::create([
            'name' => 'hardware',
        ]);
        Tag::create([
            'name' => 'software',
        ]);
        Tag::create([
            'name' => 'logical',
        ]);

        //    Execute
        $response = $this->json('GET', '/api/v1/tags');

        //    Assert
        $response->assertSuccessful();

        $tagsJson = $response->getContent();
        $tags = json_decode($tagsJson);

        $response->assertJsonCount(3);
        $this->assertEquals($tags[0]->name, "hardware");
        $this->assertEquals($tags[1]->name, "software");
        $this->assertEquals($tags[2]->name, "logical");
    }
}
