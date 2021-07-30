<?php

namespace Tests\Unit\Http\Controllers\Api\Series;


use App\Models\Series;
use App\Models\User;
use Tests\TestCase;

class SeriesUpdateControllerTest extends TestCase
{
    /**
     * @var string
     */
    protected string $token;

    /**
     * @var Series
     */
    protected $series;

    protected function setUp():void
    {
        parent::setUp();
        $this->token = User::factory()->create()->createToken('list')->accessToken;
        $this->series = Series::factory()->create();
    }

    public function testSeriesUpdateWithValidData(): void
    {
        $response = $this->postJson(route("series.update"), [
            'id' => $this->series->id,
            'title' => $this->series->title . 'Test',
        ], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(202);

        $content = json_decode($response->getContent(), true);
        $this->assertTrue($content['result']);

        $series = Series::find($this->series->id);
        $this->assertNotNull($series);
        $this->assertEquals($this->series->title . 'Test', $series->title);
    }

    public function testSeriesUpdateWithInvalidId()
    {
        $response = $this->postJson(route("series.update"), [
            'id' => 100500,
            'title' => $this->series->title . 'Test'
        ], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(500);

        $message = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('message', $message);
    }
}
